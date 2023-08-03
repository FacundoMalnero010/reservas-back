<?php

namespace modules\Administradores\Service\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use modules\Administradores\Dto\V1;
use modules\Administradores\Dto\V1\AdministradoresDto;
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
     * @return \modules\Administradores\Dto\V1\AdministradoresDto[]
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
     * @return \modules\Administradores\Dto\V1\AdministradoresDto
     * @throws ModelNotFoundException
     * @uses verificarInstanciaModelNotFound($admin)
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
     * @return \modules\Administradores\Dto\V1\AdministradoresDto
     * @throws ValidationException
     * @uses validarAdmin($request)
     */

    public function store(Request $request) : AdministradoresDto
    {
        $validator = $this->validarAdmin($request->all());

        if($validator->fails()){
            throw new ValidationException($validator);
        }
        else{
            $result = $this->administradoresRepository->store($request);
            return new AdministradoresDto($result->toArray());
        }
    }

    /**
     * Valida los nuevos datos de un admin, se modifica el almacenado
     * y se retorna el dto
     *
     * @param Request $request
     * @param int $id
     * @return \modules\Administradores\Dto\V1\AdministradoresDto
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
     * @return \modules\Administradores\Dto\V1\AdministradoresDto
     * @throws ModelNotFoundException
     */

    public function destroy(int $id) : AdministradoresDto
    {
        $result = $this->administradoresRepository->destroy($id);
        $this->verificarInstanciaModelNotFound($result);
        return new AdministradoresDto($result->toArray());
    }

    //********************** Funciones auxiliares ***************************

    /**
     * Recibe los datos de un admin y los valida
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */

    public function validarAdmin(array $data) : \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'password' => 'required|min:6',
        ]);
    }

    public function verificarInstanciaModelNotFound(mixed $a)
    {
        $a instanceof ModelNotFoundException ? (throw new ModelNotFoundException('')) : null;
    }

}
