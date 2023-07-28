<?php

namespace modules\Reservas\Http\Controllers\V1;

use App\Dto\ApiResponseDto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use modules\Reservas\Service\V1\ReservasService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ReservasController extends Controller
{

    protected ReservasService $reservasService;
    protected ApiResponseDto $apiResponseDto;

    public function __construct(ReservasService $reservasService, ApiResponseDto $apiResponseDto)
    {
        $this->reservasService = $reservasService;
        $this->apiResponseDto  = $apiResponseDto;
    }

    /**
     * Recibe un array de dto's de reservas y devuelve una respuesta json
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $reservas = $this->reservasService->index();
        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reservas, (count($reservas) > 0) ? null : 'No hay reservas aún');
    }

    /**
     * Recibe un dto de reserva y devuelve una respuesta json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFound
     */

    public function get($id)
    {
        $reserva = $this->reservasService->get($id);

        if($reserva instanceof ModelNotFoundException){
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_NOT_FOUND);
        }

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reserva);
    }

    /**
     * Recibe una colección de horarios y devuelve una respuesta json
     * 
     * @param date $fecha
     * @return \Illuminate\Http\JsonResponse
     */

    public function getHorariosReservados($fecha)
    {
        $horarios = $this->reservasService->getHorariosReservados($fecha);

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $horarios);
    }

    /**
     * Recibe un dto de reserva y devuelve una respuesta json
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */

    public function store(Request $request)
    {
        $reserva = $this->reservasService->store($request);

        if($reserva instanceof ValidationException){
            return $this->apiResponseDto->responseError(423);
        }

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reserva);
    }

    /**
     * Recibe un dto de reserva y devuelve una respuesta json
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFound
     */

    public function update(Request $request, $id)
    {
        $reserva = $this->reservasService->update($request, $id);

        if($reserva instanceof ModelNotFoundException){
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_NOT_FOUND);
        }

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reserva);
    }

    /**
     * Recibe un dto de reserva y devuelve una respuesta json
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFound
     */

    public function destroy($id)
    {
        $reserva = $this->reservasService->destroy($id);

        if($reserva instanceof ModelNotFoundException){
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_NOT_FOUND);
        }

        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reserva);
    }
}
