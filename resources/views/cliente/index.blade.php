<!doctype html>
<html lang="es">

<head>
  <title>Linq</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="index.css" media="all">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tilt+Prism&display=swap" rel="stylesheet">
  <script>
    let random = Math.floor(Math.random() * 1000)
    let css = document.querySelector('link[href="index.css"]');
    css.href = 'index.css?v='+random;
  </script>
</head>

<body>

  <!-- Menú de navegación -->
  <header>
    <ul class="nav justify-content-end">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#reservar">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sobreNosotros" onclick="activarAnimacionCards()">Acerca de</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#menu" onclick="activarAnimacionMenu()">Menu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contacto">Contacto</a>
      </li>
    </ul>
  </header>

  <main>

    <!-- Home -->
    <section class="seccion d-flex flex-column justify-content-center align-items-center" id="reservar">
        <h1 class="w-25 d-flex justify-content-center" style="user-select: none"><span style="font-family: Monstserrat; color: rgba(243, 243, 11, 0.75); -webkit-text-stroke: 1.25px black; font-weight: 500; font-size: 100px;">LINQ</span></h1>
        <button class="botonReserva btn btn-warning text-dark-50" id="boton" onclick="agregarAnimacion()"><strong>Reservar</strong></button>
    </section>

    <!-- Acerca de -->
    <section class="seccion d-flex align-items-center flex-wrap" id="sobreNosotros">
      <div class="card col-3 offset-2 h-25">
        <img src="images/historia.jpg" loading="lazy" alt="historia" class="card-img-top rounded h-100">
        <div class="card-img-overlay">
          <h2 class="card-title text-light">Historia</h2>
          <h5 class="card-text">
            Linq tiene una rica historia que se remonta a más de 50 años. Fundado por la familia Malnero en el corazón de 
            la ciudad, pronto se convirtió en el destino gastronómico más popular para aquellos que buscaban una experiencia de lujo. 
            Con el tiempo, el restaurante se ha expandido y renovado para mantenerse al día con las últimas tendencias culinarias y de 
            diseño, pero siempre ha mantenido su compromiso con la calidad, la creatividad y la excelencia
          </h5>
        </div>
      </div>
      <div class="card col-3 offset-2 h-25">
        <img src="images/vision.jpg" loading="lazy" alt="vision" class="card-img-top rounded h-100">
        <div class="card-img-overlay">
          <h2 class="card-title text-light">Vision</h2>
          <h5 class="card-text">
            Linq se enfoca en brindar una experiencia gastronómica excepcional a sus comensales. Desde el momento en que los clientes cruzan 
            la puerta, el ambiente sofisticado y acogedor los envuelve, creando una sensación de exclusividad y lujo. Los detalles en la 
            decoración, el mobiliario y la iluminación son cuidadosamente seleccionados para crear una atmósfera elegante y refinada. 
            La música suave y el servicio impecable complementan la experiencia y hacen que los clientes se sientan especiales
          </h5>
        </div>
      </div>
      <div class="card col-3 offset-2 h-25">
        <img src="images/personal.png" loading="lazy" alt="personal" class="card-img-top rounded h-100">
        <div class="card-img-overlay">
          <h2 class="card-title text-light">Personal</h2>
          <h5 class="card-text">
            Desde los meseros hasta el equipo de cocina, cada uno cumple un rol clave en el éxito de Linq. 
            La selección cuidadosa del personal es esencial para asegurar que cada uno tenga la formación y habilidades 
            necesarias para brindar un servicio excepcional. Los meseros son expertos en la carta y el maridaje de vinos; tienen una 
            actitud amable, profesional y son capaces de anticipar las necesidades de los clientes. Los chefs y sus 
            asistentes son creativos, talentosos y cuentan con un alto nivel de conocimiento culinario
          </h5>
        </div>
      </div>
      <div class="card col-3 offset-2 h-25">
        <img src="images/experiencia.png" loading="lazy" alt="experiencia" class="card-img-top rounded h-100">
        <div class="card-img-overlay">
          <h2 class="card-title text-light">Experiencia</h2>
          <h5 class="card-text">
            La experiencia que brinda Linq es verdaderamente única e inolvidable. Desde el ambiente 
            sofisticado hasta el servicio impecable y la deliciosa comida y vinos, cada detalle está diseñado para hacer que los clientes 
            se sientan especiales y disfruten de una experiencia gastronómica inolvidable
          </h5>
        </div>
      </div>
    </section>

    <!-- Menú -->
    <section class="seccion d-flex flex-column justify-content-center align-items-center" id="menu">
      <figure>
        <img src="images/menu.png" alt="menu" loading="lazy" id="menuImage" class="rounded">
      </figure>
    </section>

    <!-- Contacto -->
    <section class="seccion d-flex flex-column justify-content-center align-items-center" id="contacto">
      <div class="container d-flex justify-content-center align-items-center flex-column rounded-4 p-4" id="containerForm">
        <h2 id="tituloForm"><strong>Linq</strong></h2>
        <form method="post" class="d-flex justify-content-center align-items-center flex-column" id="form" name="form">
          <fieldset id="nombreField" class="d-flex justify-content-center align-items-center">
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" autocomplete="off" onkeyup="validarNombreOApellido('nombre')">
            <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" autocomplete="off" onkeyup="validarNombreOApellido('apellido')">
          </fieldset>
          <fieldset id="correoField">  
            <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo Electrónico" autocomplete="off" onkeyup="validarCorreo(this)">
          </fieldset>
          <fieldset id="consultaField">
            <textarea class="form-control" name="consulta" id="consulta" max="255" placeholder="Consulta" onkeyup="validarConsulta(this)"></textarea>
          </fieldset>
          <fieldset id="botonConsulta" class="text-center">
            <button type="submit" id="submit" class="btn btn-warning">Consultar</button>
          </fieldset>
        </form>
      </div>
    </section>

  </main>

  <script async src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script async src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script type="module" src="consultasBBDD.js"></script>
  <script type="module" src="accesibilidad.js"></script>
  <script type="module" src="validaciones.js"></script>
  <script type="module">

    import { scrollPausadoSmooth, menuSmooth, agregarAnimacion,
             activarAnimacionCards, activarAnimacionMenu } from './accesibilidad.js';
    import { validarDatos, validarNombreOApellido, validarCorreo, validarConsulta } from './validaciones.js';
    import { enviarConsulta } from './consultasBBDD.js';

    menuSmooth();
    document.querySelector('main').addEventListener('wheel', (event) => scrollPausadoSmooth(event));
    /* Previene que la imagen del menú se pueda arrastrar */
    document.getElementById('menuImage').addEventListener('dragstart',(evento)=>{evento.preventDefault()});
    
    let form = document.getElementById('form');
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      let correo       = document.getElementById('correo');
      let consulta     = document.getElementById('consulta');
      let datos        = ['nombre','apellido',correo,consulta];
      let datosValidos = validarDatos(datos);

      if(datosValidos){
        let boton = document.getElementById('submit');
        boton.disabled  = true;
        boton.innerHTML = 'Creando consulta';
        enviarConsulta(event.target);
      }
    });

    //Setteo las funciones globales para poder usarlas
    window.validarNombreOApellido = validarNombreOApellido;
    window.validarCorreo          = validarCorreo;
    window.validarConsulta        = validarConsulta;
    window.agregarAnimacion       = agregarAnimacion;
    window.activarAnimacionCards  = activarAnimacionCards;
    window.activarAnimacionMenu   = activarAnimacionMenu;

  </script>
</body>

</html>