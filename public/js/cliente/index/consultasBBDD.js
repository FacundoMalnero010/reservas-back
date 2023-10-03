import { dispararError, dispararExito } from "../../funcionesGenericas.js";
import { subirAHome } from "./accesibilidad.js";

const urlBase = 'http://localhost:8080/api/consultas';

/**
 * Hace una petición para almacenar una consulta
 *
 * @param {HTMLFormElement} form
 * @uses envioCompleto()
 * @uses dispararError()
 */

export async function enviarConsulta(form){
	const formData = new FormData(form);
	fetch(urlBase, {
		method: 'POST',
		body: formData
	})
	.then(response => {
		if(!response.ok){
			throw new Error('No se pudo acceder a la API');
		}
		return response.json();
	})
	.then(data => {
		data.code === 200 ? envioCompleto() : dispararError();
	})
	.catch(error => {
		throw new Error('Ocurrió algún problema en la consulta');
	})
}

/**
 * Dispara un cartel de éxito y redirige al usuario al index
 *
 * @uses dispararExito()
 * @uses subirAHome()
 */

function envioCompleto(){
	dispararExito('Su consulta se ha almacenado');
	setTimeout(subirAHome,3000);
}
