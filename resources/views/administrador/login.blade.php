<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login administrador Linq</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/administrador/login.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>
        #container {
            background: url('{{ asset("assets/administrador/login/fondo.png") }}') no-repeat center center;
            background-size: cover;
            filter: brightness(0.75);
        }
    </style>

    <body>
        <div class="d-flex justify-content-center align-items-center flex-column col-12" id="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-flex justify-content-center align-items-center flex-column col-4" id="cuadroLogin">
                <h1 id="titulo" class="mb-2">Ingreso Linq</h1>
                <form method="POST" action="{{ route('admin.login') }}" class="login-form mt-4 needs-validation col-10" id="formularioLogin" novalidate>
                    @csrf
                    <div class="mb-3 divInput">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input
                            type="text"
                            class="form-control"
                            id="usuario"
                            name="usuario"
                            autocomplete="off"
                            pattern="^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜ]+$"
                            minlength="3"
                            maxlength="50"
                            data-toggle="tooltip"
                            title=""
                            required>
                        <p class="invalid-feedback">Coloca el cursor sobre los campos para ver los errores</p>
                    </div>
                    <div class="mb-3 divInput">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            autocomplete="off"
                            pattern="^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜ.¡!]+$"
                            minlength="3"
                            maxlength="50"
                            data-toggle="tooltip"
                            title=""
                            required>
                        <p class="invalid-feedback">Coloca el cursor sobre los campos para ver los errores</p>
                    </div>
                    <div class="d-flex justify-content-center align-content-center">
                        <button class="btn btn-primary login-btn mt-4" id="submit" disabled>Ingresar</button>
                    </div>
                </form>
            </div>
        </div>

        <script type="module" src="{{ asset('js/administrador/login/validaciones.js') }}"></script>
        <script async src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script async src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>
        <script>
            //Inicializo los tooltips
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>
