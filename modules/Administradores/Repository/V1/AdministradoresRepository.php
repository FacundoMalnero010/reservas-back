<?php

namespace modules\Administradores\Repository\V1;

use app\Repository\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use modules\Administradores\Entities\Administrador;
use Carbon\Carbon;

class AdministradoresRepository extends EloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Administrador());
    }

    /**
     * Consulta y retorna todos los administradores
     * 
     * @return Collection
     */

    public function index()
    {
        return Administrador::all();
    }

    /**
     * Consulta y retorna un administrador
     * 
     * @param int $id
     * @return \modules\Administradores\Entities\Administrador
     * @throws ModelNotFoundException
     */

    public function get($id)
    {
        return Administrador::findOrFail($id);
    }

    /**
     * Almacena un administrador
     * 
     * @param Request $request
     * @uses asignarDatosAdmin($administrador,$request)
     * @return \modules\Administradores\Entities\Administrador
     */

    public function store(Request $request)
    {
        $administrador   = new Administrador;

        $adminModificado = $this->asignarDatosAdmin($administrador,$request);
        $adminModificado->save();

        return $adminModificado;
    }

    /**
     * Actualiza la información de un administrador
     * 
     * @param Request $request
     * @param int $id
     * @uses asignarDatosAdmin($administrador,$request)
     * @throws ModelNotFoundException
     */

    public function update(Request $request, $id)
    {
        $administrador   = Administrador::findOrFail($id);
        $adminModificado = $this->asignarDatosAdmin($administrador,$request);
        return $administrador;
    }

    /**
     * Hace la baja lógica de un administrador
     */

    public function destroy($id)
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->estado = 'B';
        return $administrador;
    }

    //********************** Funciones auxiliares *************************

    /**
     * Asigna los datos de un administrador y lo retorna
     * 
     * @param Administrador $administrador
     * @param Request $request
     * @return Administrador
     */

    public function asignarDatosAdmin(Administrador $administrador, Request $request)
    {
        $administrador->nombre = $request->input('nombre');
        $administrador->apellido = $request->input('apellido');
        $administrador->password = bcrypt($request->input('password'));
        $administrador->estado = 'A';
        return $administrador;
    }

}