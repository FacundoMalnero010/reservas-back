<?php

namespace modules\Administradores\Repository\V1;

use app\Repository\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $administradores   = Administrador::all();
        $adminsSinPassword = $administradores->makeHidden('password');
        return $adminsSinPassword;
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
        $administrador    = Administrador::findOrFail($id);
        $this->verificarInstanciaModelNotFound($administrador);
        return $administrador->makeHidden('password');
    }

    /**
     * Almacena un administrador
     *
     * @param Request $request
     * @return Administrador
     *@uses asignarDatosAdmin($administrador,$request)
     */

    public function store(Request $request) : Administrador
    {
        $administrador = $this->getModel();
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

    /**
     * Valida los datos de un administrador para verificar que exista
     *
     * @param Request $request
     * @return Administrador|bool
     */

    public function validarAdministrador(Request $request) : Administrador|bool
    {
        return Administrador::where('usuario',$request->get('username'))
                              ->where('password',$request->get('password'))
                              ->firstOrFail();
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

    /**
     * Recibe una variable y tira una excepción de ModelNotFound en caso de serlo
     *
     * @param mixed $a
     * @throws ModelNotFoundException
     */

    public function verificarInstanciaModelNotFound(mixed $a) : void
    {
        $a instanceof ModelNotFoundException ? (throw new ModelNotFoundException('')) : null;
    }

}
