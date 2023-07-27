<?php

namespace modules\Reservas\Repository\V1;

use app\Repository\EloquentRepository;
use Illuminate\Http\Request;
use modules\Reservas\Entities\Reserva;

class ReservasRepository extends EloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Reserva());
    }

    /**
     * Consulta y retorna todas las reservas almacenadas
     * 
     * @return Collection
     */

    public function index()
    {
        return Reserva::all();
    }

    /**
     * Consulta y retorna una reserva almacenada
     * 
     * @param int $id
     * @return \modules\Reservas\Entities\Reserva
     * @throws ModelNotFound
     */

    public function get($id)
    {
        return Reserva::findOrFail($id);
    }

    /**
     * Almacena una reserva
     * 
     * @param \Illuminate\Http\Request $request
     * @return \modules\Reservas\Entities\Reserva
     * @uses asignarDatosReserva($reserva,$request)
     */

    public function store(Request $request)
    {
        //Se obtiene el modelo
        $reserva = $this->getModel();
        $this->asignarDatosReserva($reserva, $request);

        //Se almacena la reserva
        $reserva->save();
        return $reserva;
    }

    /**
     * Actualiza datos de una reserva existente
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \modules\Reservas\Entities\Reserva
     * @throws ModelNotFound
     * @uses asignarDatosReserva($reserva,$request)
     */

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        //Si existe la reserva, la misma es modificada
        $this->asignarDatosReserva($reserva, $request);
        return $reserva;
    }

    /**
     * Hace la baja física de una reserva
     * 
     * @param int $id
     * @return \modules\Reservas\Entities\Reserva
     * @throws ModelNotFound
     */

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();
        return $reserva;
    }

    //********************** Funciones auxiliares *************************
    
    /**
     * @param \modules\Reservas\Entities\Reserva $reserva
     * @param \Illuminate\Http\Request $request
     * @return \modules\Reservas\Entities\Reserva
     */
    
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
