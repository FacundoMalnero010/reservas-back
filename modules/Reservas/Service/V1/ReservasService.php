<?php

namespace modules\Reservas\Service\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use modules\Reservas\Dto\V1\ReservaDto;
use modules\Reservas\Repository\V1\ReservasRepository;

class ReservasService
{
    protected ReservasRepository $reservasRepository;

    public function __construct(ReservasRepository $reservasRepository)
    {
        $this->reservasRepository = $reservasRepository;
    }

    public function index()
    {
        $reservasBBDD = $this->reservasRepository->index();

        $reservas = [];
        //Se convierten todas las reservas al formato dto
        //para luego ser almacenadas en el array y devueltas
        foreach($reservasBBDD as $reservaBBDD)
        {
            $reservas[] = new ReservaDto($reservaBBDD->toArray());
        }

        return $reservas;
    }

    public function get($id)
    {
        try
        {
            $reserva = $this->reservasRepository->get($id);
            return new ReservaDto($reserva->toArray());
        }
        catch (ModelNotFoundException $e)
        {
            return $e;
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validarReserva($request->all());

        //Si los datos no se validan se lanza una excepción
        if($validator->fails())
        {
            throw new ValidationException();
        }
        else
        {
            $result = $this->reservasRepository->store($request);
            return new ReservaDto($result->toArray());
        }

    }

    public function update(Request $request, $id)
    {
        try
        {
            $result = $this->reservasRepository->update($request, $id);
            return new ReservaDto($result->toArray());
        }
        catch (ModelNotFoundException $e)
        {
            return $e;
        }
    }

    public function destroy($id)
    {
        try
        {
            $result = $this->reservasRepository->destroy($id);
            return new ReservaDto($result->toArray());
        }
        catch (ModelNotFoundException $e)
        {
            return $e;
        }
    }

    //********************** Funciones auxiliares ***************************

    public function validarReserva(array $data)
    {
        return Validator::make($data, [
           'fecha'      => 'required|date',
           'horario'    => 'required|time',
           'comensales' => 'required|numeric|digits_between:1,12',
           'email'      => 'required|string',
           'nombre'     => 'required|string'
        ]);
    }
}
