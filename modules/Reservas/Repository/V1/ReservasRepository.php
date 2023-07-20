<?php

namespace modules\Reservas\Repository\V1;

use app\Repository\EloquentRepository;
use Illuminate\Http\Request;
use modules\Entities\Reserva;

class ReservasRepository extends EloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Reserva());
    }

    public function index()
    {
        return Reserva::all();
    }

    public function get($id)
    {
        return Reserva::findOrFail($id);
    }

    public function store(Request $request)
    {
        //Se obtiene el modelo
        $reserva = $this->getModel();
        $this->asignarDatosReserva($reserva, $request);

        //Se almacena la reserva
        $reserva->save();
        return $reserva;
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        //Si existe la reserva, la misma es modificada
        $this->asignarDatosReserva($reserva, $request);
        return $reserva;
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();
        return $reserva;
    }

    //********************** Funciones auxiliares *************************
    public function asignarDatosReserva(Reserva $reserva, Request $request)
    {
        $reserva->fecha      = $request->input('fecha');
        $reserva->horario    = $request->input('horario');
        $reserva->comensales = $request->input('comensales');
        $reserva->email      = $request->input('email');
        $reserva->nombre     = $request->input('nombre');

        return $reserva;
    }
}
