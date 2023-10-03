/**
 * Permite que al clickear en los refs del menú se haga una transición smooth hacia la sección
 */

export function menuSmooth(){
    document.querySelectorAll('a[href^="#"]').forEach(selector => {
        //Href smooth
        selector.addEventListener('click',function(e){  
          e.preventDefault();
        
          document.querySelector(this.getAttribute('href')).scrollIntoView({behavior: 'smooth'});
        });
        //Anulo drags
        selector.addEventListener('dragstart',(evento)=>{
          evento.preventDefault();
        });
    });
}

let canScroll  = true;
const sobreNos = document.getElementById('sobreNosotros');
const menu     = document.getElementById('menu');
const cards    = document.querySelectorAll('#sobreNosotros .card');

/**
 * Permite el scrolleo smooth y bloquea momentáneamente el scroll para que la transición se complete
 * 
 * @param {WheelEvent} event 
 */

export function scrollPausadoSmooth(event){
  // previene el desplazamiento predeterminado del mouse
  event.preventDefault();
  // si no se puede hacer scroll, salimos de la función
  if (canScroll){
    // obtiene la dirección del desplazamiento del mouse
    const direction = event.deltaY > 0 ? 1 : -1;
    // establece un tiempo de espera antes de poder hacer scroll de nuevo3
    canScroll = false;
    setTimeout(() => scrolleoEntreSecciones(sobreNos,menu,cards), 250);
    setTimeout(() => (canScroll = true), 1000);
    // obtiene la siguiente sección
    const currentSection = event.target.closest(".seccion");
    // si hay una siguiente sección y la dirección es hacia abajo, desplázate a ella con un efecto suave
    if (currentSection.nextElementSibling && direction === 1) {
      const nextSection = currentSection.nextElementSibling;
      nextSection.scrollIntoView({behavior: "smooth", duration: 1000});
    }
    // si hay una sección anterior y la dirección es hacia arriba, desplázate a ella con un efecto suave
    if (currentSection.previousElementSibling && direction === -1) {
      currentSection.previousElementSibling.scrollIntoView({behavior: "smooth",duration: 1000});
    }
  }
}


let animacionCards = false, animacionMenu = false;

/**
 * Maneja las animaciones de los elementos de las secciones
 * 
 * @param {HTMLElement}   sobreNos
 * @param {HTMLElement}   menu
 * @param {HTMLElement[]} cards
 */

function scrolleoEntreSecciones(sobreNos,menu,cards){
    // verifico la posicion actual de la pantalla
    const position = window.scrollY;
    // si me encuentro en la seccion 2, le agrego animación
    if(position < sobreNos.offsetTop && !animacionCards){
        activarAnimacionCards(cards);
    }
    if(position < menu.offsetTop && position > sobreNos.offsetTop && !animacionMenu){
        activarAnimacionMenu();
    }
}

/**
 * Activa la animación de las cards en la sección acerca-de
 */

export function activarAnimacionCards(){
    if(!animacionCards){
      let cards = document.querySelectorAll('.card');
      cards.forEach(card => {card.classList.add('deslizar')});
      animacionCards = true;
    }
}

/**
 * Activa la animación del menú en la sección menú
 */

export function activarAnimacionMenu(){
    if(!animacionMenu){
      const menuImage = document.getElementById('menuImage');
      menuImage.classList.add('agrandar');
      animacionMenu = true;
    }
}

/**
 * Agrega una animación de expansión al botón de reserva
 */

export function agregarAnimacion(){
      const boton = document.getElementById('boton');
      boton.classList.add('waves');
      setTimeout(() => {window.location.href = '../reserva/reserva.html'}, 1000);
}

/**
 * Realiza una transición smooth hacia la primera sección
 */

export function subirAHome(){
    window.scrollTo({top:0,behavior:'smooth'});
}