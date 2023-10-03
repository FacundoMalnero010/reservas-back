/**
 * Realiza las validaciones de los inputs del form de 
 * 
 * @param {HTMLElement[]} datos 
 * @returns {boolean}
 */

export function validarDatos(datos){
    let datosValidaron = true;

    datosValidaron = validarNombreOApellido(datos[0]);
    datosValidaron = validarNombreOApellido(datos[1]);
    datosValidaron = validarCorreo(datos[2]);
    datosValidaron = validarConsulta(datos[3]);
    
    return datosValidaron;
}

/**
 * Valida el formato de un nombre o apellido
 * 
 * @param {string} nombre 
 * @returns {boolean}
 */

export function validarNombreOApellido(valor){
    const regex = /^[\wáéíóúÁÉÍÓÚñÑ]{3,}$/;
    if(valor === 'nombre'){
      let nombre   = document.getElementById('nombre');
      if(!regex.test(nombre.value)){
        invalido(nombre);
        return false;
      }
      else{
        valido(nombre);
        return true;
      }
    }
    else{
      let apellido = document.getElementById('apellido');
      if(!regex.test(apellido.value)){
        invalido(apellido);
        return false;
      }
      else{
        valido(apellido);
        return true;
      }
    }
}

/**
 * Valida el formato de un correo electrónico
 * 
 * @param {string} correo 
 * @returns {boolean}
 */

export function validarCorreo(correo){
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  if(!regex.test(correo.value)){
    invalido(correo);
    return false;
  }
  else{
    valido(correo);
    return true;
  }
}

/**
 * Valida el formato de una consulta
 * 
 * @param {string} consulta 
 * @returns {boolean}
 */

export function validarConsulta(consulta){
  const regex = /^[a-zA-Z0-9ñÑ¿¡\s!?]{3,255}$/;
  if(!regex.test(consulta.value)){
    invalido(consulta);
    return false;
  }
  else{
    valido(consulta);
    return true;
  }
}

/**
 * Valida el campo recibido
 * 
 * @param {HTMLElement} input 
 */

function valido(input){
  if(input.classList.contains('is-invalid')){
    input.classList.remove('is-invalid');
  }
  input.classList.add('is-valid');
}

/**
 * Invalida el campo recibido
 * 
 * @param {HTMLElement} input
 */

function invalido(input){
  if(input.classList.contains('is-valid')){
    input.classList.remove('is-valid');
  }
  input.classList.add('is-invalid');
}