/**
 * Utiliza Swal para mostrar un cartel de error
 */

export function dispararError(mensaje){
    Swal.fire({
        icon:  'error',
        title: 'Oops...',
        text:  mensaje
    });
}

/**
 * Utiliza Swal para mostrar un cartel de exito
 * 
 * @param {string} mensaje
 */

export function dispararExito(mensaje){
    Swal.fire({
		icon: 'success',
		title: 'Éxito',
		text: mensaje
	});
}

/**
 * Hashea una url
 * 
 * @param {URL} url
 * @returns {string}
 */

export function hashURL(url){
    return crypto.createHash('md5').update(str).digest('hex');
}