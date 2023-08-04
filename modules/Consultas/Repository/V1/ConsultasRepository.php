<?php

namespace modules\Consultas\Repository\V1;

use app\Repository\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use modules\Consultas\Entities\Consulta;
use Carbon\Carbon;

class ConsultasRepository extends EloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Consulta());
    }

    /**
     * Consulta y retorna todas las consultas almacenadas
     *
     * @return Collection
     */

    public function index() : Collection
    {
        return Consulta::all();
    }

    /**
     * Consulta y retorna una consulta almacenada
     *
     * @param int $id
     * @return Consulta
     * @throws ModelNotFoundException
     */

    public function get(int $id) : Consulta
    {
        return Consulta::findOrFail($id);
    }

    /**
     * Almacena una consulta
     *
     * @param Request $request
     * @return Consulta
     */

    public function store(Request $request) : Consulta
    {
        $consulta = new Consulta;

        $consultaModificada = $this->asignarDatosConsulta($consulta,$request);
        $consultaModificada->save();

        return $consultaModificada;
    }

    /* No es necesaria aún
    public function update(Request $request, $id)
    {

    }
    */

    /**
     * Hace la baja física de una consulta
     *
     * @param int $id
     * @return Consulta
     * @throws ModelNotFoundException
     */

    public function destroy(int $id) : Consulta
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();
        return $consulta;
    }

    //********************** Funciones auxiliares *************************

    /**
     * Asigna los datos de un request al modelo consulta recibido y lo retorna
     *
     * @param Consulta $consulta
     * @param Request $request
     * @return Consulta
     */

    public function asignarDatosConsulta(Consulta $consulta, Request $request)
    {
        $consulta->nombre   = $request->input('nombre');
        $consulta->apellido = $request->input('apellido');
        $consulta->email    = $request->input('correo');
        $consulta->consulta = $request->input('consulta');
        return $consulta;
    }

}
