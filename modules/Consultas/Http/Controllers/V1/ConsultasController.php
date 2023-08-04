<?php

namespace modules\Consultas\Http\Controllers\V1;

use App\Dto\ApiResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use modules\Consultas\Dto\V1\ConsultaDto;
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
     * @return JsonResponse
     */

    public function index() : JsonResponse
    {
        $consultas = $this->consultasService->index();
        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $consultas, (count($consultas) > 0) ? null : 'No hay consultas aún');
    }

    /**
     * Recibe un dto de consulta y devuelve una respuesta json
     *
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @uses gestionarRetorno($consulta, 404)
     */

    public function get(int $id) : JsonResponse
    {
        $consulta = $this->consultasService->get($id);
        return $this->gestionarRetorno($consulta, 404);
    }

    /**
     * Recibe un dto de consulta y devuelve una respuesta json
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @uses gestionarRetorno($consulta, 423)
     */

    public function store(Request $request) : JsonResponse
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
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @uses gestionarRetorno($consulta, 404)
     */

    public function destroy(int $id) : JsonResponse
    {
        $consulta = $this->consultasService->destroy($id);
        return $this->gestionarRetorno($consulta, 404);
    }

    //********************** Funciones auxiliares *************************

    /**
     * Verifica si la respuesta es una excepción o no y
     * devuelve lo correspondiente
     *
     * @param ConsultaDto $response
     * @param int $posibleCodError
     * @return JsonResponse
     */

    public function gestionarRetorno(ConsultaDto $response,int $posibleCodError) : JsonResponse
    {
        if($response instanceof ModelNotFoundException || $response instanceof ValidationException)
        {
            return $this->apiResponseDto->responseError($posibleCodError);
        }

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $response);
    }

}
