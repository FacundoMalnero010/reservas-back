<?php

namespace modules\Reservas\Service\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use modules\Reservas\Dto\V1\ReservaDto;
use modules\Reservas\Repository\V1\ReservasRepository;

class ReservasService
{
    protected ReservasRepository $reservasRepository;

    public function __construct(ReservasRepository $reservasRepository)
    {
        $this->reservasRepository = $reservasRepository;
    }

    /**
     * Recibe una colección de todas las reservas y retorna un array de Dto's de las mismas
     * 
     * @return \modules\Reservas\Dto\V1\ReservaDto[]
     */
    
    public function index()
    {
        $reservasBBDD = $this->reservasRepository->index();

        $reservas = [];
        //Se convierten todas las reservas al formato dto
        //para luego ser almacenadas en el array y devueltas
        foreach($reservasBBDD as $reservaBBDD)
        {
            $reservas[] = new ReservaDto($reservaBBDD->toArray());
        }

        return $reservas;
    }

    /**
     * Recibe una reserva y se retorna el dto
     * 
     * @param int $id
     * @return \modules\Reservas\Dto\V1\ReservaDto
     * @throws ModelNotFound
     * @uses verificarInstanciaModelNotFound($reserva)
     */

    public function get($id)
    {
        $reserva = $this->reservasRepository->get($id);

        $this->verificarInstanciaModelNotFound($reserva);
        
        return new ReservaDto($reserva->toArray());
    }

    /**
     * Recibe una colección de horarios y los retorna
     * 
     * @param date $fecha
     * @return time[]
     */

    public function getHorariosReservados($fecha)
    {
        return $this->reservasRepository->getHorariosReservados($fecha);
    }

    /**
     * Valida los datos de reserva, se recibe la reserva almacenada
     * y se retorna el dto
     * 
     * @param \Illuminate\Http\Request $request
     * @return \modules\Reservas\Dto\V1\ReservaDto
     * @throws ValidationException
     * @uses validarReserva($request)
     */

    public function store(Request $request)
    {
        $validator = $this->validarReserva($request->all());

        //Si los datos no se validan se lanza una excepción
        if($validator->fails())
        {
            throw new ValidationException('');
        }
        else
        {
            $result = $this->reservasRepository->store($request);
            return new ReservaDto($result->toArray());
        }

    }

    /**
     * Recibe una reserva modificada y se retorna el dto
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \modules\Reservas\Dto\V1\ReservaDto
     * @throws ModelNotFound
     * @uses verificarInstanciaModelNotFound($reserva)
     */

    public function update(Request $request, $id)
    {
        $reserva = $this->reservasRepository->update($request, $id);

        $this->verificarInstanciaModelNotFound($reserva);
        
        return new ReservaDto($reserva->toArray());
    }

    /**
     * Recibe una reserva eliminada y se retorna el dto
     * 
     * @param int $id
     * @return \modules\Reservas\Dto\V1\ReservaDto
     * @throws ModelNotFound
     * @uses verificarInstanciaModelNotFound($reserva)
     */

    public function destroy($id)
    {
        $reserva = $this->reservasRepository->destroy($id);

        $this->verificarInstanciaModelNotFound($reserva);
        
        return new ReservaDto($reserva->toArray());
    }

    //********************** Funciones auxiliares ***************************

    /**
     * Recibe los datos de una reserva y los valida
     * 
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */

    public function validarReserva(array $data)
    {
        return Validator::make($data, [
           'fecha'      => 'required|date',
           'horario'    => 'required|date_format:H:i',
           'comensales' => 'required|numeric|digits_between:1,12',
           'email'      => 'required|string',
           'nombre'     => 'required|string'
        ]);
    }

    public function verificarInstanciaModelNotFound($a)
    {
        $a instanceof ModelNotFoundException ? (throw new ModelNotFoundException('')) : null;
    }
}
