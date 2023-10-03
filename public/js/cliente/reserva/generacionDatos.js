import { deshabilitarSubmit } from "./validaciones.js";
import { dispararExito } from "../../funcionesGenericas.js";

/**
 * Genera los horarios, establece la primera fecha
 * disponible y deshabilita submit
 *
 * @uses establecerMinimoDiaReserva()
 * @uses generarHorarios()
 * @uses deshabilitarSubmit()
 */

export function generarEntorno(){
	establecerMinimoDiaReserva();
	generarHorarios();
	deshabilitarSubmit();
}

/**
 * Obtiene los input del form y los retorna en forma de array
 *
 * @returns {HTMLElement[]}
 */

export function obtenerCamposForm(){
	const fecha      = document.getElementById('fecha');
	const comensales = document.getElementById('comensales');
	const email      = document.getElementById('email');
	const horario    = document.getElementById('horario');
	const nombre     = document.getElementById('nombre');
	const inputs     = [fecha, horario, comensales, nombre, email];
	return inputs;
}

/**
 * Retorna el dia actual
 *
 * @returns {time}
 */

function fechaActual(){
	const fechaActual = new Date();
	fechaActual.setDate(fechaActual.getDate() + 1);
	return fechaActual;
}

/**
 * Retorna el dia siguiente al actual
 *
 * @returns {time}
 * @uses fechaActual()
 */

function diaSiguiente(){
	const hoy = fechaActual();
	return hoy.toISOString().split('T')[0];
}

/**
 * Establece el dia siguiente al actual como primer posible
 * dia de reserva
 *
 * @uses diaSiguiente()
 */

export function establecerMinimoDiaReserva(){
	const fechaInput = document.getElementById('fecha');
	const diaMinimo  = diaSiguiente();
	fechaInput.setAttribute('min', diaMinimo);
}

/**
 * Establece los posibles horarios de reserva
 */

export function generarHorarios(){
	let hora = 19, minutos = 0;
	let select = document.getElementById('horario');

	for(let i = 0; i<20; i++){
		if(i === 0){
			let opcion = new Option(hora+':'+minutos+'0',hora+':'+minutos+'0');
			select.appendChild(opcion);
		}
		else{
			let opcion;
			if(minutos == 45){
				minutos = 0;
				hora++;
			}
			else{
				minutos += 15;
			}
			if(minutos === 0){
				opcion = new Option(hora+':'+minutos+'0',hora+':'+minutos+'0');
			}
			else{
				opcion = new Option(hora+':'+minutos,hora+':'+minutos);
			}
			select.appendChild(opcion);
		}
	}
}

/**
 * Redirige luego de unos segundos al index
 */

export function envioCompleto(){
	dispararExito('Su reserva se ha almacenado');
	setTimeout(redirigirAInicio,3000);
}

/**
 * Redirige al usuario al index
 */

function redirigirAInicio(){
	window.location.href = '../index/index.html';
}
