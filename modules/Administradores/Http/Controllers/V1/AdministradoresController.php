<?php

namespace modules\Consultas\Http\Controllers\V1;

use App\Dto\ApiResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $admins = $this->administradoresService->index();
        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $admins, (count($admins) > 0) ? null : 'No hay administradores aún');
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */

    public function get($id)
    {
        $admin = $this->administradoresService->get($id);
        return $this->gestionarRetorno($admin, 404);
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */

    public function store(Request $request)
    {
        $admin = $this->administradoresService->store($request);
        return $this->gestionarRetorno($admin, 423);
    }

    /**
     * Recibe un dto de admin y devuelve una respuesta json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     * @throws ValidationException
     */

    public function update(Request $request, $id)
    {
        $admin = $this->administradoresService->update($request,$id);
        return $this->gestionarRetorno($admin,404,423);
    }

    /**
     * Recibe un dto de admin y devuelve un json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy($id)
    {
        $admin = $this->administradoresService->destroy($id);
        return $this->gestionarRetorno($admin,404);
    }

    //********************** Funciones auxiliares *************************

    /**
     * Verifica si la respuesta es una excepción o no y
     * devuelve lo correspondiente
     * 
     * @param \modules\Administradores\Dto\V1\AdministradoresDto $response
     * @param int $posibleCodError
     * @return \Illuminate\Http\JsonResponse
     */

     public function gestionarRetorno($response,$posibleCodError,$segundoPosibleCodError = null)
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