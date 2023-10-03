<!doctype html>
<html lang="es">

<head>
  <title>Reserva Linq</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<link rel="shortcut icon" href="../index/images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="reserva.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
</head>

<body>
  <header>
  </header>
  <main>
	<div id="contenedor" class="d-flex justify-content-center align-items-center">
		<div id="contenedorForm" class="d-flex justify-content-center align-items-center flex-column">
			<h1>Linq</h1>
			<form method="post" action="" class="d-flex justify-content-center align-items-center flex-column col-9" id="form" name="form">
				<div class="d-flex justify-content-center align-items-center col-11">
					<div class="d-flex justify-content-center align-items-center flex-column col-5">
						<label for="fecha">Dia</label>
						<input type="date" name="fecha" id="fecha" min="" class="form-control" onchange="validar();verificarDisponibilidad()" onkeydown="validar()">
					</div>
					<div class="d-flex justify-content-center align-items-center flex-column offset-2 col-5">
						<label for="hora">Horario</label>
						<select type="time" id="horario" class="form-control" name="horario" onchange="validar()" disabled>
							<option value="" selected></option>
						</select>
					</div>
				</div>
				<div class="d-flex justify-content-center align-items-center col-11 mt-3">
					<div class="d-flex justify-content-center align-items-center flex-column col-5">
						<label for="comensales">Comensales</label>
						<input type="number" name="comensales" id="comensales" class="form-control" placeholder="0" min="1" onchange="validar()">
					</div>
					<div class="d-flex justify-content-center align-items-center flex-column offset-2 col-5">
						<label for="nombre" id="nombreLabel">Nombre</label>
						<input type="text" name="nombre" id="nombre" class="form-control" placeholder="John" onchange="validar()" onkeydown="validar()">
					</div>
				</div>
				<div class="d-flex justify-content-center align-items-center flex-column col-11 mt-3">
					<label for="email" id="emailLabel">Email</label>
					<input type="email" name="email" id="email" class="form-control" placeholder="tuemail@gmail.com" onchange="validar()" onkeydown="validar()">
				</div>
				<button type="submit" id="submit" class="btn mt-4" disabled>Reservar</button>
			</form>
		</div>
	</div>

  </main>
  <footer>

  </footer>
  	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
	integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
		integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
	</script>
	<script type="module">
		import { verificarDisponibilidad, validarForm, 
			     deshabilitarSubmit, habilitarSubmit } 
		from "./validaciones.js";
		import { generarEntorno, envioCompleto } from './generacionDatos.js';
		import { generarReserva } from './consultasBBDD.js';

		const botonSubmit = document.getElementById('submit');

		/**
		* Realiza la validación del form y habilita, o no, el submit 
		*/

		let validar = () => validarForm() ? habilitarSubmit() : deshabilitarSubmit();
		
		//Al terminar de cargar el DOM se establecen datos primordiales
		document.addEventListener('DOMContentLoaded', () => {
			generarEntorno();			
		});

		//Establecemos las funciones de manera global para poder usarlas
		window.validar = validar;
		window.verificarDisponibilidad = verificarDisponibilidad;

		let form = document.getElementById('form');
		//Se realiza el envio del formulario
		form.addEventListener('submit', function(event){
			event.preventDefault();
			if(validarForm()){
				botonSubmit.disabled  = true;
				botonSubmit.innerText = 'Reservando';
				generarReserva(event.target);
			}
		});

	</script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>