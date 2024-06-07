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
                            <a class="navbar-brand" href="#">ASISTENTE DE COSTEO</a>
                            <!-- <form id="consulta-form" class="ms-auto">
                                <button type="button" id="consulta-btn" class="btn btn-primary">
                                    <i class="fas fa-cogs fa-1x"></i> EJECUTAR ASISTENTE 
                                </button>
                            </form> -->
                        </div>
                    </nav>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="indicador" class="d-none text-center">
                                <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-2"></i>
                                <p class="mb-0">Cargando...</p>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table" id="costoarticulos-table">
                                    <thead>
                                        <tr>
                                            <th>Codigo Articulo</th>
                                            <th>Descripcion Articulo</th>
                                            <th>Bodega</th>
                                            <th>Nombre Bodega</th>
                                            <th>Stock</th>
                                            <th>Precio kilo Original</th>
                                            <th>Precio kilo Revalorizado</th>
                                            <th>Total stock por precio kilo</th>
                                            <th>id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table body content will be populated dynamically -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script>
$(document).ready(function() {
    $('#consulta-btn').on('click', function() {
        var itemCode = $('input[name="item_code"]').val();

        $.ajax({
            url: '{{ url("api/Logistica-costeo-articulos") }}', // URL directa
            type: 'GET',
            data: {
                item_code: itemCode
            },
            beforeSend: function() {
                $('#indicador').removeClass('d-none');
            },
            success: function(data) {
                var tableBody = $('#costoarticulos-table tbody');
                tableBody.empty();

                $.each(data.calculatedData, function(index, row) {
                    var formattedOriginalAvgPrice = row.originalAvgPrice === null ? '$ NaN' : parseFloat(row.originalAvgPrice).toLocaleString(
                        'es-CO', {
                            style: 'currency',
                            currency: 'COP'
                        });

                    var formattedCalculatedAvgPrice = parseFloat(row.calculatedAvgPrice).toLocaleString(
                        'es-CO', {
                            style: 'currency',
                            currency: 'COP'
                        });

                    var formattedCostoCompleto = parseFloat(row.Costo_Completo).toLocaleString(
                        'es-CO', {
                            style: 'currency',
                            currency: 'COP'
                        });

                    var newRow = '<tr>' +
                        '<td>' + row.ItemCode + '</td>' +
                        '<td>' + row.ItemName + '</td>' +
                        '<td>' + row.WhsCode + '</td>' +
                        '<td>' + row.WhsName + '</td>' +
                        '<td>' + row.OnHand + '</td>' +
                        '<td>' + formattedOriginalAvgPrice + '</td>' +
                        '<td>' + formattedCalculatedAvgPrice + '</td>' +
                        '<td>' + formattedCostoCompleto + '</td>' +
                        '<td>' + row.id__ + '</td>' +
                        '</tr>';
                    tableBody.append(newRow);
                });

                $('#indicador').addClass('d-none');
                // Mostrar notificación exitosa usando SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Consulta exitosa',
                    text: 'Los datos se han consultado y calculado correctamente.',
                });
            },
            error: function() {
                $('#indicador').addClass('d-none');
                // Mostrar notificación de error usando SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al consultar SAP.',
                });
            }
        });
    });
});
</script>
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