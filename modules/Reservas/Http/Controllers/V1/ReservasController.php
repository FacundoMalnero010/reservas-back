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

    public function index()
    {
        $reservas = $this->reservasService->index();
        return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reservas, (count($reservas) > 0) ? null : 'No hay reservas aún');
    }

    public function get($id)
    {
        try{
            $reserva = $this->reservasService->get($id);
            return $this->apiResponseDto->response(ResponseAlias::HTTP_OK, $reserva);
        }
        catch (ModelNotFoundException $e)
        {
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        try{
            $result = $this->reservasService->store($request);
            return $this->apiResponseDto->response(ResponseAlias::HTTP_OK);
        }
        catch (ValidationException $e)
        {
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_CONFLICT);
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            $result = $this->reservasService->update($request,$id);
            return $this->apiResponseDto->response(ResponseAlias::HTTP_OK);
        }
        catch (ModelNotFoundException $e)
        {
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->reservasService->destroy($id);
            return $this->apiResponseDto->response(ResponseAlias::HTTP_OK);
        }
        catch (ModelNotFoundException $e)
        {
            return $this->apiResponseDto->responseError(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
