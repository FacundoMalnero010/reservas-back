<?php

namespace modules\Consultas\Repository\V1;

use app\Repository\EloquentRepository;
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

    public function index()
    {
        return Consulta::all();
    }

    /**
     * Consulta y retorna una consulta almacenada
     * 
     * @param int $id
     * @return \modules\Consultas\Entities\Consulta
     * @throws ModelNotFound
     */

    public function get($id)
    {
        return Consulta::findOrFail($id);
    }

    /**
     * Almacena una consulta
     * 
     * @param \Illuminate\Http\Request $request
     * @return \modules\Consultas\Entities\Consulta
     */

    public function store(Request $request)
    {
        //Se obtiene el modelo
        $consulta = $this->getModel();
        
        $this->asignarDatosConsulta($consulta,$request);

        return $consulta;
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
     * @return \modules\Consultas\Entities\Consulta
     * @throws ModelNotFound
     */

    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();
        return $consulta;
    }

    //********************** Funciones auxiliares *************************

    /**
     * @param \modules\Consultas\Entities\Consulta
     * @param \Illuminate\Http\Request $request
     * @return \modules\Consultas\Entities\Consulta
     */

    public function asignarDatosConsulta(Consulta $consulta, Request $request)
    {
        $consulta->nombre = $request->input('nombre');
        $consulta->apellido = $request->input('apellido');
        $consulta->email = $request->input('email');
        $consulta->consulta = $request->input('consulta');
        $consulta->save();
    }

}