import { obtenerFechasOcupadas } from './consultasBBDD.js';
import { obtenerCamposForm } from './generacionDatos.js';
import { dispararError } from '../../funcionesGenericas.js';

/**
 * Modifica el DOM restringiendo los horarios reservados
 * del dia seleccionado
 *
 * @uses obtenerFechasOcupadas(fecha)
 * @uses esInstanciaError(fecha)
 * @uses resetearHorarios()
 */

const boton   = document.getElementById('submit');
const horario = document.getElementById('horario');

export async function verificarDisponibilidad(){
    horario.disabled = true;
    let fecha = document.getElementById('fecha').value;
	let horariosOcupados = await obtenerFechasOcupadas(fecha);
    if(!esInstanciaError(fecha)){
        //Se cambia el formato HH:MM:SS a HH:MM
        let horariosFormateados = horariosOcupados.map(horario => horario.slice(0,5));
        resetearHorarios();
        deshabilitarHorariosReservados(horariosFormateados);
    }
}

/**
 * Valida que el email contenga el formato correcto y que no haya
 * campos vacios
 *
 * @param {HTMLElement[]} inputs
 * @returns {boolean}
 * @uses obtenerCamposForm()
 */

export function validarForm(){
    //Obtenemos los campos a validar
    let campos = obtenerCamposForm();
    const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let inputsValues = campos.map(input => input.value);

    //Validamos campos
	return inputsValues.some(elemento => elemento === "") || !regexCorreo.test(inputsValues[4]) ? false : true;
}

/**
 * Verifica si una variable es instancia de error
 *
 * @param {any} data
 * @returns {boolean}
 */

function esInstanciaError(data){
    if(data instanceof Error){
        dispararError();
        return true;
    }
    return false;
}

/**
 * Vacia el campo de horario y vuelve a habilitar todas las opciones
 */

function resetearHorarios(){
    //Anulo horario al cambiar de dia
    horario.value = '';
    let options = horario.options;
    //Se habilitan todos los horarios
    for(let i=0;i<options.length;i++){
        if(options[i].classList.contains('ocupado')){
            options[i].classList.remove('ocupado');
            options[i].disabled = false;
        }
    }
}

/**
 * Deshabilita los horarios que recibe
 *
 * @param {time[]} horariosOcupados
 */

function deshabilitarHorariosReservados(horariosOcupados){
    //Por cada horario recibido se busca el que coincida
    //, si existe, en el input y lo deshabilita
    horariosOcupados.forEach(horario => {
        let option = document.querySelector('select[name="horario"] option[value="'+horario+'"]');
        option.disabled = true;
        option.classList.add('ocupado');
    });
    horario.disabled = false;
}

/**
 * Deshabilita el botón de submit
 */

export function deshabilitarSubmit(){
    boton.disabled    = true;
    boton.id 		  = 'noSubmit';
    boton.innerHTML   = 'Complete los campos';
}

/**
 * Habilita el botón de submit
 */

export function habilitarSubmit(){
    boton.disabled    = false;
    boton.id          = 'submit';
    boton.innerHTML   = 'Reservar';
}
