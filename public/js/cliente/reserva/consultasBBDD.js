import { envioCompleto } from "./generacionDatos.js";
import { dispararError } from "../../funcionesGenericas.js";

export const urlReservas = 'http://localhost:8080/api/reservas'

/**
 *
 * @param {Date} fecha
 * @returns {Time[]}
 */

export async function obtenerFechasOcupadas(fecha){
    return fetch(urlReservas+'/horariosReservados/'+fecha)
        .then(response => {
            if(!response.ok){
                throw new Error('No se pudo acceder a la API');
            }
            return response.json();
        })
        .then(data => {
            let arrayReservas = data.result;
            return arrayReservas;
        })
        .catch(error => {
            throw new Error('Ocurrió algún problema en la consulta');
        });
}

/**
 * Hace una petición para almacenar una reserva
 *
 * @param {HTMLFormElement} form
 * @uses envioCompleto()
 * @uses dispararError()
 */

export async function generarReserva(form){
    const formData = new FormData(form);
    fetch(urlReservas, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if(!response.ok){
            throw new Error('No se pudo generar la reserva');
        }
        return response.json();
    })
    .then(data => {
        data.code === 200 ? envioCompleto() : dispararError();
    })
    .catch(error => {
        throw new Error('No se pudo generar la reserva');
    })
}
