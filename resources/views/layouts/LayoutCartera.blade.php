<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="logo">
                    GESTIÓN DE CARTERA


                </div>
                <a class="nav-link" data-toggle="dropdown" href="#" 	>
                    <i class="fas fa-th-large"></i>
                    <span class="hidden-md-down">
                        <b>{{ Auth::user()->Nombre_Empleado }}</b>
                    </span>
                </a>


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-home"></i> Inicio</a>
                        </li>
                        <!-- Agregar un submenú desplegable bajo el elemento "Cartera" -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="carteraDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-chart-bar"></i> Cartera
                            </a>
                            <div class="dropdown-menu" aria-labelledby="carteraDropdown">
                                <a class="dropdown-item" href="{{url('Solicitudes-creditos')}}">Solicitudes de credito
                                    nuevas</a>
                                <a class="dropdown-item" href="{{url('Solicitudes-creditos-rechazadas')}}">Solicitudes
                                    de credito Rechazadas</a>
                                <a class="dropdown-item" href="{{url('Solicitudes-creditos-aprobadas')}}">Solicitudes de
                                    credito Aprobadas</a>

                            </div>
                            <div class="dropdown-menu" aria-labelledby="carteraDropdown">
                                <a class="dropdown-item" href="{{url('Solicitudes-creditos')}}">Solicitudes de credito
                                    Aprobadas</a>
                                <a class="dropdown-item" href="#">Solicitudes de credito Aprobadas</a>

                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-exchange-alt"></i> Transacciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-file-alt"></i> Informes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-users"></i> CRM</a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="nav-link btn-logout"><i class="fas fa-sign-out-alt"></i> Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            @yield('content')
            <!-- Contenido específico de la vista se insertará aquí -->
        </div>
    </main>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <!-- Footer y otros elementos comunes van aquí -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Gestión de Cartera doblamos</p>
        </div>
    </footer>
</body>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</html>


<style>
.nav-link {
    text-decoration: none;
    color: #333;
    /* Color del texto */
    font-size: 20px;
    margin-right: 20px;
    /* Ajusta el espaciado derecho según tus necesidades */
}

.nav-link:hover {
    color: #555;
    /* Cambia el color del texto al pasar el ratón sobre él */
}

.fas {
    margin-right: 5px;
    /* Espaciado entre el icono y el texto */
}

.hidden-md-down {
    display: inline-block;
    /* Hace visible el span */
    font-weight: bold;
    /* Texto en negrita */
}

/* Estilos globales */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    max-width: 2250px;
    margin: 0 auto;
    padding: 0 20px;
}

header {
    background-color: #004170;
    ;
    color: #fff;
    padding: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.navbar-nav li i {
    font-size: 18px;
    margin-right: 8px;
}

header h1 {
    margin: 0;
    font-size: 36px;
}

.navbar-nav li a {
    color: gray;
    font-weight: 500;
    font-size: 16px;
}

.navbar-nav li {
    display: flex;
    align-items: center;
}

.navbar-nav li a:hover {
    color: #ffc107;
    /* Cambia al color que prefieras */
}

.navbar-toggler {
    border: none;
    background-color: transparent;
}

.navbar-toggler-icon {
    background-color: #fff;
    /* Color del icono del botón */
}

.dropdown-menu {
    padding: 10px;
    border: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    color: #333;
    /* Color del texto del menú desplegable */
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    /* Color de fondo al pasar el cursor */
}



nav ul {
    list-style: none;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

.navbar {
    background-color: #004170;
}


nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
}

main {
    padding: 40px 0;
}

/* Estilos para los botones */
button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    margin-right: 10px;
}

/* Estilos para el gráfico (puede requerir JavaScript y una librería de gráficos) */
.chart {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
}

/* Estilos para el footer */
footer {
    background-color: #004170;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
}

footer p {
    margin: 0;
    font-size: 18px;
}

.nav-item,
.dropdown-menu,
.nav-link {
    transition: color 0.3s ease, background-color 0.3s ease;
}

.navbar-toggler-icon {
    transition: background-color 0.3s ease;
}

.nav-item:hover,
.dropdown-item:hover {
    background-color: #0061a8;
    /* Color más claro */
    color: #fff;
}

.btn-logout {
    transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-link:hover {
    color: #ffc107;
}

.dropdown-menu {
    border: 1px solid #ccc;
}


/* Estilos para las tablas */
.table {
    width: 100%;
    margin-top: 10px;
}

.table th,
.table td {
    padding: 15px;
    text-align: left;
}

.table th {
    background-color: #004170;
    ;
    color: #fff;
}

.table tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}

/* Estilos para íconos */
i {
    margin-right: 5px;
}

/* Estilos para botones en las tablas */
.table button {
    padding: 5px 10px;
    font-size: 14px;
    margin: 0;
}

/* Estilos para botones de acciones en filas */
.btn-primary {
    background-color: #004170;
    border: none;
    color: #fff;
}

.btn-primary:hover {
    background-color: #004170;
}

.btn-danger {
    background-color: #e74c3c;
    border: none;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c0392b;
}

.logo {
    color: #ffc107;
    /* Cambia al color que prefieras */
    margin: 16px;
    font-size: 24px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    /* Sombreado ligero */
}
</style>