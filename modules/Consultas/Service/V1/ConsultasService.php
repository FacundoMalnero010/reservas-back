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
     * @return \modules\Consultas\Dto\V1\ConsultaDto[]
     */

    public function index()
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
     * @return \modules\Consultas\Dto\V1\ConsultaDto
     * @throws ModelNotFound
     * @uses verificarInstanciaModeloNotFound($consulta)
     */

    public function get($id)
    {
        $consulta = $this->consultasRepository->get($id);

        $this->verificarInstanciaModelNotFound($consulta);

        return new ConsultaDto($consulta->toArray());
    }

    /**
     * Valida los datos de consulta, se recibe la consulta almacenada
     * y se retorna el dto
     * 
     * @param \Illuminate\Http\Request $request
     * @return \modules\Consultas\Dto\V1\ConsultaDto
     * @throws ValidationException
     * @uses validarConsulta($request)
     */

    public function store(Request $request)
    {
        $validator = $this->validarConsulta($request->all());

        //Si los datos no se validan se lanza una excepción
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
     * @return \modules\Consulta\Dto\V1\ConsultaDto
     * @throws ModelNotFound
     * @uses verificarInstanciaModelNotFound($consulta)
     */

    public function destroy($id)
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

    public function validarConsulta(array $data)
    {
        return Validator::make($data, [
            'nombre'   => 'required|string',
            'apellido' => 'required|string',
            'email'    => 'required|string',
            'consulta' => 'required|string',
        ]);  
    }

    public function verificarInstanciaModelNotFound($a)
    {
        $a instanceof ModelNotFoundException ? (throw new ModelNotFoundException('')) : null;
    }

}