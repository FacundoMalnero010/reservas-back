/*************************************************************************/
/*                              Variables                                */
/*************************************************************************/

const botonSubmit = document.getElementById('submit');

/*************************************************************************/
/*                              Listeners                                */
/*************************************************************************/

document.querySelectorAll('input').forEach(input => {
    input.addEventListener('keyup', validarCampos);
});

botonSubmit.addEventListener('click', () => {
    !botonSubmit.disabled ? setTimeout(() => {botonSubmit.disabled = true},5) : 0;
});

/*************************************************************************/
/*                              Funciones                                */
/*************************************************************************/

/**
 * Valida los campos de un formulario
 */

function validarCampos() {
    let camposInvalidos = 0;

    document.querySelectorAll('input').forEach(input => {
        if (!input.checkValidity()) {
            input.classList.add('is-invalid');
            input.title = input.validationMessage;
            camposInvalidos = 1;
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            input.title = '';
        }
    });

    botonSubmit.disabled = camposInvalidos;

}
