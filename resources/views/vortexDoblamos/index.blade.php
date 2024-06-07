@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection

@section('content')
<br>
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
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <br>
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">COTIZADOR VORTEX</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Cotizaciones
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('vortexDoblamos.create') }}">Generar
                                            cotización</a>
                                        <a class="dropdown-item" href="{{url('Seguimientos-vortex')}}">Seguimientos crm</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Historicos
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ url('vortexDoblamos/Historico') }}">Historial
                                            de
                                            Cotizaciones</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Informes
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ url('Analisis_ventavor') }}">Análisis de
                                            Ventas</a>
                                        <a class="dropdown-item" href="{{ route('vortex.Indicadores') }}">Ver
                                            Indicadores</a>
                                        <a class="dropdown-item" href="{{ route('vortex.export') }}">exportar excel
                                            seguimientos</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <br>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <p>Corrige los siguientes errores: El cliente no se guardó correctamente</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        
                        <div class="w-100" style="height: 400px;">
                        <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                    
                        <div class="w-100" style="height: 400px;">
                            <!-- Ajusta las dimensiones según tus necesidades -->
                            <canvas id="clientChart"></canvas>
                        </div>
                    </div>

                </div>




            </div>

        </div>


    </div>
    <!-- <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatableinfo">
                        <thead class="table-dark">
                            <tr>
                                <th>#Obra</th>
                                <th>Cliente</th>
                                <th>Nombres</th>
                                <th>Teléfono</th>
                                <th>Nombre Obra</th>
                                <th>Lugar Obra</th>
                                <th>Fecha Recibido</th>
                                <th>Fecha Cotizada</th>
                                <th>Fecha Venta</th>
                                <th>Valor A.Iva</th>
                                <th>Valor Adjudicado</th>
                                <th>Tipología</th>
                                <th>Estado</th>
                                <th>$M2</th>
                                <th>Incluye Montaje</th>
                                <th>Origen</th>
                                <th>Asesor</th>
                                <th>País</th>
                                <th>Metros Cuadrados</th>
                                <th>Fecha Venta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vorte as $row)
                            <tr>
                                <td>{{ $row->Total_Asesor }}</td>
                                <td>{{ $row->CardCode }}</td>
                                <td>{{ $row->CardName }}</td>
                                <td>{{ $row->Phone1 }}</td>
                                <td>{{ $row->Nombre_Obra }}</td>
                                <td>{{ $row->Lugar_Obra }}</td>
                                <td>{{ $row->Fecha_Recibido }}</td>
                                <td>{{ $row->Fecha_Cotizada }}</td>
                                <td>{{$row->Fecha_Venta}}</td>
                                <td>${{ number_format($row->Valor_Antes_Iva) }}</td>
                                <td>${{ number_format($row->Valor_Adjudicado) }}</td>
                                <td>{{ $row->Tipologia }}</td>
                                @if($row->Estado == 'Perdida')
                                <td class="btn btn-danger btn-estado">{{ $row->Estado }}</td>
                                @elseif($row->Estado == 'Seguimiento')
                                <td class="btn btn-sm btn-danger bg-warning btn-estado">{{ $row->Estado }}</td>
                                @elseif($row->Estado == 'Vendida')
                                <td class="btn btn-sm btn-success btn-estado">{{ $row->Estado }}</td>
                                @elseif($row->Estado == 'Pendiente')
                                <td class="btn btn-sm btn-danger btn-estado">{{ $row->Estado }}</td>
                                @elseif($row->Estado == 'Cerrada')
                                <td class="btn btn-light btn-estado">{{ $row->Estado }}</td>
                                @elseif($row->Estado == 'Adjudicada')
                                <td class="btn btn-light btn-estado">{{ $row->Estado }}</td>
                                @elseif($row->Estado == 'No cotizada')
                                <td class="btn btn-light btn-estado">{{ $row->Estado }}</td>
                                @endif
                                <td>${{ number_format($row->m2) }}</td>
                                <td>{{ $row->Incluye_Montaje }}</td>
                                <td>{{ $row->Origen }}</td>
                                <td>{{ $row->Nombre_Asesor }}</td>
                                <td>{{ $row->countryName }}</td>
                                <td>{{ $row->Metros_Cuadrados }}</td>
                                <td>{{$row->Fecha_Venta}}</td>
                                <td>
                                    <form action="{{route('vortex.destroy',$row->id)}}" method="POST"
                                        class="formulario-eliminar" class="formulario-eliminar">
                                        @csrf
                                        @method('PUT')
                                        <a class="btn btn-sm btn-success"
                                            href="{{route('vortexDoblamos.edit',$row->id)}}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> -->
</div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
<script>
$(document).ready(function() {
    $('#vorte-table').DataTable();
});
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('eliminar') == 'ok')
<script>
swal.fire(
    'Eliminado!',
    'Seguimiento de la cotización eliminado correctamente!',
    'success'
)
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: '¿Estás seguro que deseas eliminar el seguimiento?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Sí, eliminarlo'
    }).then((result) => {
        if (result.value) {
            this.submit();
        }
    })
});



// Datos para la gráfica
var data = {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
    datasets: [{
        label: 'Ventas Mensuales',
        data: [12, 19, 3, 5, 2],
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    }]
};

// Configuración de la gráfica
var options = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
};

// Crear el contexto del gráfico
var ctx = document.getElementById('myChart').getContext('2d');

// Crear la gráfica de barras
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});
</script>
<script>
// Datos para la gráfica
var data = {
    labels: ['Cliente A', 'Cliente B', 'Cliente C', 'Cliente D', 'Cliente E'],
    datasets: [{
        data: [30, 20, 15, 10, 25],
        backgroundColor: ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6'],
        hoverBackgroundColor: ['#2980b9', '#c0392b', '#27ae60', '#d35400', '#8e44ad']
    }]
};

// Configuración de la gráfica
var options = {
    responsive: true,
    maintainAspectRatio: false
};

// Crear el contexto del gráfico
var ctx = document.getElementById('clientChart').getContext('2d');

// Crear la gráfica de pastel
var clientChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});
</script>
@endsection