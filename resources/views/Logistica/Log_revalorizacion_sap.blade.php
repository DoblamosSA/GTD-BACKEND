@extends('layouts.dashboard')

@section('template_title')
    Asistente Costeo de Artículos por Bodega
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <div class="container">
                            <a class="navbar-brand" href="#">LOG REVALORIZACIÓNES SAP</a>
                        </div>
                    </nav>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="costoarticulos-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Fecha y Hora</th>
                                            <th>Nivel</th>
                                            <th>Mensaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (explode("\n", $logContent) as $line)
                                    @php
                                    // Verificar si la línea tiene el formato esperado
                                    if (strpos($line, "] ") !== false && strpos($line, ".") !== false) {
                                    // Dividir la línea por el delimitador "] "
                                    list($datetime, $message) = explode("] ", $line, 2);
                                    // Eliminar los corchetes iniciales y espacio en la fecha y hora
                                    $datetime = substr($datetime, 1);
                                    // Separar el nivel y el mensaje
                                    list($level, $message) = explode(".", $message, 2);
                                    } else {
                                    // Si la línea no tiene el formato esperado, asignar un valor por defecto
                                    $datetime = "";
                                    $level = "";
                                    $message = $line;
                                    }
                                    @endphp
                                    <tr>
                                        <td>{{ $datetime }}</td>
                                        <td>{{ $level }}</td>
                                        <td>{{ $message }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script>
    // Configuración y activación de DataTables
    $(document).ready(function() {
        $('#costoarticulos-table').DataTable({
            // Opciones personalizadas de DataTables aquí
        });
    });
</script>
@endsection

@section('styles')
<style>
.btn-estado {
    width: 150px;
    /* ajustar el ancho según sus necesidades */
}

/* Estilos personalizados para la navbar */
.navbar {
    background-color: #34495e;
}

.navbar-toggler-icon {
    background-color: #ecf0f1;
}

.navbar-brand {
    color: #ecf0f1;
    font-weight: bold;
}

.navbar-nav .nav-link {
    color: #ecf0f1;
    font-weight: 500;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #f39c12;
}

.navbar-nav .nav-item.active .nav-link {
    color: #f39c12;
}

.navbar-nav .dropdown-menu {
    background-color: #2c3e50;
    border: none;
    border-radius: 0;
}

.navbar-nav .dropdown-item {
    color: #ecf0f1;
    transition: background-color 0.3s ease;
}

.navbar-nav .dropdown-item:hover {
    background-color: #f39c12;
    color: #fff;
}

/* Estilos para la tabla */
#costoarticulos-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#costoarticulos-table th,
#costoarticulos-table td {
    border: 1px solid #ced4da;
    padding: 8px;
    text-align: center;
}

#costoarticulos-table th {
    background-color: #007bff;
    color: #fff;
}

#costoarticulos-table tr:hover {
    background-color: #f1f1f1;
}

.indicador {
    background-color: white;
}
</style>
@endsection





<style>
.btn-estado {
    width: 150px;
    /* ajustar el ancho según sus necesidades */
}

/* Estilos personalizados para la navbar */
.navbar {
    background-color: #34495e;
}

.navbar-toggler-icon {
    background-color: #ecf0f1;
}

.navbar-brand {
    color: #ecf0f1;
    font-weight: bold;
}

.navbar-nav .nav-link {
    color: #ecf0f1;
    font-weight: 500;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #f39c12;
}

.navbar-nav .nav-item.active .nav-link {
    color: #f39c12;
}

.navbar-nav .dropdown-menu {
    background-color: #2c3e50;
    border: none;
    border-radius: 0;
}

.navbar-nav .dropdown-item {
    color: #ecf0f1;
    transition: background-color 0.3s ease;
}

.navbar-nav .dropdown-item:hover {
    background-color: #f39c12;
    color: #fff;
}

/* Estilos para la tabla */
#costoarticulos-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#costoarticulos-table th,
#costoarticulos-table td {
    border: 1px solid #ced4da;
    padding: 8px;
    text-align: center;
}

#costoarticulos-table th {
    background-color: #007bff;
    color: #fff;
}

#costoarticulos-table tr:hover {
    background-color: #f1f1f1;
}

.indicador {
    background-color: white;
}
</style>