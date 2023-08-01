<?php

namespace modules\Consultas\Http\Controllers\V1;

use App\Dto\ApiResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use modules\Consultas\Service\V1\ConsultasService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ConsultasController extends Controller
{

    protected ConsultasService $consultasService;
    protected ApiResponseDto $apiResponseDto;

    public function __construct(ConsultasService $consultasService, ApiResponseDto $apiResponseDto)
    {
        $this->consultasService = $consultasService;
        $this->apiResponseDto  = $apiResponseDto;
    }

    /**
     * Recibe un array de dto's de consultas y devuelve una respuesta json
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(){
        $consultas = $this->consultasService->index();
        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $consultas, (count($consultas) > 0) ? null : 'No hay consultas aún');
    }

    /**
     * Recibe un dto de consulta y devuelve una respuesta json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */

    public function get($id)
    {
        $consulta = $this->consultasService->get($id);
        return $this->gestionarRetorno($consulta, 404);
    }

    /**
     * Recibe un dto de consulta y devuelve una respuesta json
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */

    public function store(Request $request)
    {
        $consulta = $this->consultasService->store($request);
        return $this->gestionarRetorno($consulta, 423);
    }

    /* No se usa aún
    public function update(Request $request, $id)
    {

    }
    */

    /**
     * Recibe un dto de consulta y devuelve una respuesta json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */

    public function destroy($id)
    {
        $consulta = $this->consultasService->destroy($id);
        return $this->gestionarRetorno($consulta, 404);
    }

    //********************** Funciones auxiliares *************************

    /**
     * Verifica si la respuesta es una excepción o no y
     * devuelve lo correspondiente
     * 
     * @param \modules\Consultas\Dto\V1\ConsultaDto $response
     * @param int $posibleCodError
     * @return \Illuminate\Http\JsonResponse
     */

    public function gestionarRetorno($response,$posibleCodError)
    {
        if($response instanceof ModelNotFoundException || $response instanceof ValidationException)
        {
            return $this->apiResponseDto->responseError($posibleCodError);
        }

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $response);
    }

}