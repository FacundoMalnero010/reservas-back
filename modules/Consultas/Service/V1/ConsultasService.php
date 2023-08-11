<?php

namespace modules\Consultas\Service\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use modules\Consultas\Dto\V1\ConsultaDto;
use modules\Consultas\Repository\V1\ConsultasRepository;

class ConsultasService
{
    protected ConsultasRepository $consultasRepository;

    public function __construct(ConsultasRepository $consultasRepository)
    {
        $this->consultasRepository = $consultasRepository;
    }

    /**
     * Recibe una colección de todas las consultas y retorna un array de Dto's de las mismas
     *
     * @return ConsultaDto[]
     */

    public function index() : array
    {
        $consultasBBDD = $this->consultasRepository->index();

        $consultas = [];

        //Se convierten todas las consultas al formato dto
        //para luego ser almacenadas en el array y devueltas
        foreach($consultasBBDD as $consultaBBDD)
        {
            $consultas[] = new ConsultaDto($consultaBBDD->toArray());
        }

        return $consultas;
    }

    /**
     * Recibe una consulta y retorna el dto
     *
     * @param int $id
     * @return ConsultaDto
     * @throws ModelNotFoundException
     * @uses verificarInstanciaModeloNotFound($consulta)
     */

    public function get(int $id) : ConsultaDto
    {
        $consulta = $this->consultasRepository->get($id);

        $this->verificarInstanciaModelNotFound($consulta);

        return new ConsultaDto($consulta->toArray());
    }

    /**
     * Valida los datos de consulta, se recibe la consulta almacenada
     * y se retorna el dto
     *
     * @param Request $request
     * @return ConsultaDto
     * @throws ValidationException
     * @uses validarConsulta($request)
     */

    public function store(Request $request) : ConsultaDto
    {
        $validator = $this->validarConsulta($request->all());

        if ($validator->fails()){
            throw new ValidationException($validator);
        }
        else{
            $result = $this->consultasRepository->store($request);
            return new ConsultaDto($result->toArray());
        }
    }

    /* No se usa aún
    public function update()
    {

    }
    */

    /**
     * Recibe una consulta eliminada y se retorna el dto
     *
     * @param int $id
     * @return ConsultaDto
     * @throws ModelNotFoundException
     * @uses verificarInstanciaModelNotFound($consulta)
     */

    public function destroy(int $id) : ConsultaDto
    {
        $consulta = $this->consultasRepository->destroy($id);

        $this->verificarInstanciaModelNotFound($consulta);

        return new ConsultaDto($consulta->toArray());
    }

    //********************** Funciones auxiliares ***************************

    /**
     * Recibe los datos de una consulta y los valida
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */

    public function validarConsulta(array $data) : \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'nombre'   => 'required|string',
            'apellido' => 'required|string',
            'correo'    => 'required|string',
            'consulta' => 'required|string',
        ]);
    }

    /**
     * Recibe una variable y tira una excepción de ModelNotFound en caso de serlo
     *
     * @param mixed $a
     * @throws ModelNotFoundException
     */

    public function verificarInstanciaModelNotFound($a) : void
    {
        $a instanceof ModelNotFoundException ? (throw new ModelNotFoundException('')) : null;
    }

}
