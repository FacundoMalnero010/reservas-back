<?php

namespace modules\Consultas\Http\Controllers\V1;

use App\Dto\ApiResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Factory;
use modules\Administradores\Dto\V1\AdministradoresDto;
use modules\Administradores\Service\V1\AdministradoresService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdministradoresController extends Controller
{

    protected AdministradoresService $administradoresService;
    protected ApiResponseDto $apiResponseDto;

    public function __construct(AdministradoresService $administradoresService, ApiResponseDto $apiResponseDto)
    {
        $this->administradoresService = $administradoresService;
        $this->apiResponseDto  = $apiResponseDto;
    }

    /**
     * Recibe un array de dto's de admins y devuelve una respuesta json
     *
     * @return JsonResponse
     */

    public function index() : JsonResponse
    {
        $admins = $this->administradoresService->index();

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $admins, (count($admins) > 0) ? null : 'No hay administradores aún');
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     *
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @uses gestionarRetorno
     */

    public function get(int $id) : JsonResponse
    {
        $admin = $this->administradoresService->get($id);

        return $this->gestionarRetorno($admin, 404);
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @uses AdministradoresService::store
     * @uses gestionarRetorno
     */

    public function store(Request $request) : JsonResponse
    {
        $datos = $this->administradoresService->store($request);

        return $this->gestionarRetorno($datos, 423);
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @uses gestionarRetorno
     */

    public function update(Request $request, int $id): JsonResponse
    {
        $admin = $this->administradoresService->update($request,$id);
        return $this->gestionarRetorno($admin,404,423);
    }

    /**
     * Recibe un dto de admin y devuelve un json
     *
     * @param int $id
     * @return JsonResponse
     * @uses gestionarRetorno($admin, 404)
     */

    public function destroy(int $id): JsonResponse
    {
        $admin = $this->administradoresService->destroy($id);
        return $this->gestionarRetorno($admin,404);
    }

    /**
     * Permite el acceso al área de administración si matchean los datos
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @uses AdministradoresService::login
     */
    public function login(Request $request) : RedirectResponse
    {
        try {
            $this->administradoresService->login($request);
            return redirect()->route('homeAdmin');
        }
        catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['Sus credenciales son incorrectas'])->withInput();
        }

    }

    /**
     * Llama una función que desloguea al administrador
     * para luego redirigirlo a la página de login
     *
     * @param Request $request
     * @uses AdministradoresService::logout
     * @return RedirectResponse
     */

    public function logout(Request $request): RedirectResponse
    {
        $this->administradoresService->logout($request);
        return redirect()->route('login');
    }

    /**
     * Retorna la vista home del administrador
     *
     * @return View
     */

    public function home(): View
    {
        return view('administrador.index');
    }

    //********************** Funciones auxiliares *************************

    /**
     * Verifica si la respuesta es una excepción o no y
     * devuelve lo correspondiente
     *
     * @param mixed $response
     * @param int $posibleCodError
     * @param int|null $segundoPosibleCodError
     * @return JsonResponse
     */

     public function gestionarRetorno(mixed $response,int $posibleCodError,int $segundoPosibleCodError = null) : JsonResponse
     {
         if($response instanceof ModelNotFoundException)
         {
             return $this->apiResponseDto->responseError($posibleCodError);
         }
         if($response instanceof ValidationException)
         {
            return $this->apiResponseDto->responseError($segundoPosibleCodError);
         }

         return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $response);
     }

    //********************** Funciones vistas *************************

    /**
     * Retorna la vista del formulario de login del administrador
     *
     * @return Factory|View
     */

    public function formLogin() : Factory|View
    {
        return view('administrador.login');
    }

}
