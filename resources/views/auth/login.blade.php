

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div id="contenedor">
    <div id="contenedorcentrado">
        <div id="login" class="animated fadeIn">
            <form autocomplete='off' method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="titulo">Iniciar sesion</h3>
                <div class="form-group">
                    <label for="email">Usuario</label>
                    <input autocomplete='off' id="email" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required />
                </div>
                <div class="form-group">
                    <label for="password">Clave</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Iniciar sesion
                </button>


            </form>

        </div>
        <div id="derecho" class="animated fadeIn">
            <div class="logo-empresa">
                <img src="{{ asset('images/logodoblamos.png') }}" alt="GTD-FINANCIERO Logo">

            </div>
            @error('password')
            <div class="alert alert-danger mt-3 animated fadeIn ">
                {{ $message }}
            </div>
            @enderror

            @error('name')
            <div class="alert alert-danger mt-3 animated fadeIn ">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>


<style scoped>
    /* Estilos generales */
    body {
        font-family: "Overpass", sans-serif;
        font-weight: normal;
        font-size: 100%;
        color: #1b262c;
        margin: 0;
        background-color: #ffff;
    }

    /* Estilos para el contenedor de pantalla completa */
    #contenedor {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 0;
        min-width: 100vw;
        min-height: 100vh;
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
    }

    /* Estilos para el contenedor centrado */
    #contenedorcentrado {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        min-width: 320px;
        max-width: 900px;
        width: 90%;
        background-color: #000000ed;
        border-radius: 10px;
        box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
        padding: 30px;
        box-sizing: border-box;
    }

    /* Estilos para el formulario de login */
    #login {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        background-color: rgb(28, 26, 26);
        box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
        border-radius: 3px;
        box-sizing: border-box;
        opacity: 1;
    }

    #login label {
        display: block;
        font-size: 120%;
        color: #ffffff;
        margin-top: 15px;
    }

    #login input {
        font-size: 110%;
        color: #1b262c;
        display: block;
        width: 100%;
        height: 40px;
        margin-bottom: 10px;
        padding: 5px 10px;
        box-sizing: border-box;
        border: none;
        border-radius: 3px;
    }

    #login input::placeholder {
        color: #e4e4e4;
    }

    #login button {
        font-size: 110%;
        color: #1b262c;
        width: 100%;
        height: 40px;
        border: none;
        border-radius: 3px;
        background-color: #dfcdc3;
        margin-top: 10px;
    }

    #login button:hover {
        background-color: #3c4245;
        color: #dfcdc3;
    }

    /* Estilos para la sección de la derecha */
    #derecho {
        text-align: center;
        width: 100%;
        opacity: 0.7;
        padding: 20px;
        box-sizing: border-box;
    }

    .titulo {
        font-size: 200%;
        color: #dfcdc3;
    }

    .logo-empresa img {
        max-width: 80%;
        height: auto;
        border-radius: 50%;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    hr {
        border-top: 1px solid #8c8b8b;
        border-bottom: 1px solid #dfcdc3;
    }

    .pie-form {
        font-size: 90%;
        text-align: center;
        margin-top: 15px;
    }

    .pie-form a {
        display: block;
        text-decoration: none;
        color: #dfcdc3;
        margin-bottom: 3px;
    }

    .pie-form a:hover {
        color: #719192;
    }

    @media all and (max-width: 775px) {

        /* Estilos responsivos */
        #contenedorcentrado {
            flex-direction: column;
            align-items: center;
        }

        #login {
            margin-bottom: 20px;
        }

        .logo-empresa img {
            width: 200px;
        }
    }

    .alert-danger {
        color: #dc3545;
        /* Este color es rojo, puedes ajustarlo según tus preferencias */
    }
</style>