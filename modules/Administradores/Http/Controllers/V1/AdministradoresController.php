<?php

namespace modules\Consultas\Http\Controllers\V1;

use App\Dto\ApiResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
     * @uses gestionarRetorno($admin, 404)
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
     * @uses gestionarRetorno($admin, 404)
     */

    public function store(Request $request) : JsonResponse
    {
        $admin = $this->administradoresService->store($request);
        return $this->gestionarRetorno($admin, 423);
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     *
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws ValidationException
     * @uses gestionarRetorno($admin, 404)
     */

    public function update(Request $request, int $id)
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

    public function destroy(int $id)
    {
        $admin = $this->administradoresService->destroy($id);
        return $this->gestionarRetorno($admin,404);
    }

    //********************** Funciones auxiliares *************************

    /**
     * Verifica si la respuesta es una excepción o no y
     * devuelve lo correspondiente
     *
     * @param AdministradoresDto $response
     * @param int $posibleCodError
     * @return JsonResponse
     */

     public function gestionarRetorno(AdministradoresDto $response,int $posibleCodError,int $segundoPosibleCodError = null)
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

}
