<?php

namespace modules\Administradores\Repository\V1;

use app\Repository\EloquentRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;
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
        $administrador = Administrador::findOrFail($id);
        $this->verificarInstanciaModelNotFound($administrador);
        return $administrador->makeHidden('password');
    }

    /**
     * Almacena un administrador
     *
     * @param Request $request
     * @return Administrador
     */

    public function store(Request $request) : Administrador
    {
        return Administrador::create([
            'nombre'     => $request->get('nombre'),
            'apellido'   => $request->get('apellido'),
            'usuario'    => $request->get('usuario'),
            'password'   => Hash::make($request->get('password')),
            'estado'     => 'A',
        ]);
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
     * Verifica, en primera instancia, que el administrador no se encuentre
     * logueado ya. En caso de no estarlo, intenta loguearlo con las credenciales
     * brindadas y le crea un token
     *
     * @param Request $request
     * @return Authenticatable|bool
     * @throws ModelNotFoundException
     */

    public function login(Request $request) : Authenticatable|bool
    {

        if (Auth::attempt($request->only('usuario', 'password'))) {

            //La regeneración de sesión evita ataques CSRF
            $request->session()->regenerate(1);

            return 1;

        }

        throw new ModelNotFoundException();

    }

    public function logout(Request $request)
    {

    }

    //********************** Funciones auxiliares *************************

    /**
     * Recibe una variable y tira una excepción de ModelNotFound en caso de serlo
     *
     * @param mixed $a
     * @throws ModelNotFoundException
     */

    public function verificarInstanciaModelNotFound(mixed $a) : void
    {
        $a instanceof ModelNotFoundException ?? throw new ModelNotFoundException('');
    }

}
