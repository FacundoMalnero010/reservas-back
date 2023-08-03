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

    public function index() : Collection
    {
        return Administrador::all();
    }

    /**
     * Consulta y retorna un administrador
     *
     * @param int $id
     * @return Administrador
     * @throws ModelNotFoundException
     */

    public function get(int $id) : Administrador
    {
        return Administrador::findOrFail($id);
    }

    /**
     * Almacena un administrador
     *
     * @param Request $request
     * @uses asignarDatosAdmin($administrador,$request)
     * @return Administrador
     */

    public function store(Request $request) : Administrador
    {
        $administrador = new Administrador;
        $adminConDatos = $this->asignarDatosAdmin($administrador,$request);
        $adminFinal    = $this->generarUsuario($adminConDatos, false);
        $adminFinal->save();

        return $adminFinal;
    }

    /**
     * Actualiza la información de un administrador
     *
     * @param Request $request
     * @param int $id
     * @uses asignarDatosAdmin($administrador,$request)
     * @throws ModelNotFoundException
     */

    public function update(Request $request, int $id) : Administrador
    {
        $administrador   = Administrador::findOrFail($id);
        $adminModificado = $this->asignarDatosAdmin($administrador,$request);
        $adminFinal      = $this->generarUsuario($adminModificado, true);
        $adminFinal->save();
        return $adminFinal;
    }

    /**
     * Hace la baja lógica de un administrador
     *
     * @param int $id
     * @return Administrador
     * @throws ModelNotFoundException
     */

    public function destroy(int $id) : Administrador
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->estado = 'B';
        $administrador->save();
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

    public function asignarDatosAdmin(Administrador $administrador, Request $request) : Administrador
    {
        $administrador->nombre   = $request->input('nombre');
        $administrador->apellido = $request->input('apellido');
        $administrador->password = bcrypt($request->input('password'));
        $administrador->estado   = 'A';
        return $administrador;
    }

    /**
     * Genera un usuario para un admin y retorna este último
     *
     * @param Administrador $administrador
     * @param bool $esUpdate
     * @return Administrador
     */

    public function generarUsuario(Administrador $administrador, bool $esUpdate) : Administrador
    {
        if(!$esUpdate) {
            $idUltimoAdmin = Administrador::latest('id')->value('id');
            if ($idUltimoAdmin !== null) {
                $administrador->usuario = $administrador->nombre . $administrador->apellido . ($idUltimoAdmin + 1);
            } else {
                $administrador->usuario = $administrador->nombre . $administrador->apellido . 1;
            }
        }
        else {
            $administrador->usuario = $administrador->nombre . $administrador->apellido . $administrador->id;
        }

        return $administrador;
    }

}
