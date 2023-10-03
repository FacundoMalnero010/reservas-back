<?php

namespace modules\Administradores\Service\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use modules\Administradores\Dto\V1\AdministradoresDto;
use App\Models\User;
use modules\Administradores\Entities\Administrador;
use modules\Administradores\Repository\V1\AdministradoresRepository;

class AdministradoresService
{
    protected AdministradoresRepository $administradoresRepository;

    public function __construct(AdministradoresRepository $administradoresRepository)
    {
        $this->administradoresRepository = $administradoresRepository;
    }

    /**
     * Recibe una colección de todos los administradores y retorna un array de Dto's de los mismos
     *
     * @return AdministradoresDto[]
     */

    public function index() : array
    {
        $adminsBBDD = $this->administradoresRepository->index();

        $administradores = [];

        //Se convierten todos los admin al formato dto
        //para luego ser almacenados en el array y devueltos
        foreach($adminsBBDD as $adminBBDD)
        {
            $administradores[] = new AdministradoresDto($adminBBDD->toArray());
        }

        return $administradores;
    }

    /**
     * Recibe un admin y retorna el dto
     *
     * @param int $id
     * @return AdministradoresDto
     * @throws ModelNotFoundException
     * @uses verificarInstanciaModelNotFound
     */

    public function get(int $id) : AdministradoresDto
    {
        $admin = $this->administradoresRepository->get($id);

        $this->verificarInstanciaModelNotFound($admin);

        return new AdministradoresDto($admin->toArray());
    }

    /**
     * Valida los datos de un admin, se recibe el admin almacenado
     * y se retorna el dto
     *
     * @param Request $request
     * @return AdministradoresDto
     * @throws ValidationException
     * @uses validarAdmin
     */

    public function store(Request $request) : AdministradoresDto
    {
        $validator = $this->validarAdmin($request->all());

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        return new AdministradoresDto((array)$this->administradoresRepository->store($request));
    }

    /**
     * Valida los nuevos datos de un admin, se modifica el almacenado
     * y se retorna el dto
     *
     * @param Request $request
     * @param int $id
     * @return AdministradoresDto
     * @throws ModelNotFoundException
     * @throws ValidationException
    */

    public function update(Request $request, int $id) : AdministradoresDto
    {
        $validator = $this->validarAdmin($request->all());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
        else{
            $admin = $this->administradoresRepository->update($request,$id);
            $this->verificarInstanciaModelNotFound($admin);
            return new AdministradoresDto($admin->toArray());
        }
    }

    /**
     * Recibe un admin dado de baja y se retorna el dto
     *
     * @param int $id
     * @return AdministradoresDto
     * @throws ModelNotFoundException
     */

    public function destroy(int $id) : AdministradoresDto
    {
        $result = $this->administradoresRepository->destroy($id);
        $this->verificarInstanciaModelNotFound($result);
        return new AdministradoresDto($result->toArray());
    }

    /**
     * Valida los datos de un administrador y, en caso de error, los retorna
     *
     * @param Request $request
     * @return AdministradoresDto|RedirectResponse|bool
     * @throws ModelNotFoundException|ValidationException
     * @uses AdministradoresRepository::login
     */

    public function login(Request $request) : AdministradoresDto|RedirectResponse|bool
    {

        Validator::make($request->all(), [

            'usuario'  => 'required|min:3|max:50|regex:/^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜ]+$/',
            'password' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜ.¡!]+$/'

        ],
        [

            'usuario.required'  => 'El campo usuario es obligatorio',
            'usuario.min'       => 'El campo usuario debe tener un mínimo de 3 caracteres',
            'usuario.max'       => 'El campo usuario debe tener un máximo de 50 caracteres',
            'usuario.regex'     => 'El nombre de usuario no cumple con el formato requerido',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.min'      => 'El campo contraseña debe tener un mínimo de 3 caracteres',
            'password.max'      => 'El campo contraseña debe tener un máximo de 50 caracteres',
            'password.regex'    => 'La contraseña no cumple con el formato requerido'

        ])->validate();

        try {

            return $this->administradoresRepository->login($request);

        }
        catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException();

        }
    }

    public function logout(Request $request)
    {
        return [Auth::user()];
        /*if(!auth()->user()) {
            return '0';
        }

        $tokenRecibido = $request->bearerToken();

        if($tokenRecibido == session('access_token')) {
            session()->forget('access_token');
            \auth()->logout();
            return '1';
        }

        return '2';*/
    }

    //********************** Funciones auxiliares ***************************

    /**
     * Recibe los datos de un admin y los valida
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */

    public function validarAdmin(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'nombre'   => 'required|string',
            'apellido' => 'required|string',
            'usuario'  => 'required|string|max:255|unique:administradores',
            'password' => 'required|string|min:8'
        ]);
    }

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
