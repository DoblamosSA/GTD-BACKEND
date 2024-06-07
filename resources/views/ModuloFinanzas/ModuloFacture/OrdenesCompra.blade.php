@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection

@section('content')
<br>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <br>
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">Consultar Pedidos SAP</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">

                                <form action="{{ url('api/ConsultapedidosCompraSAP') }}" method="get"
                                    class="form-inline">
                                    @csrf <!-- Corrección de la etiqueta -->
                                    <div class="form-row align-items-center">
                                        <div class="col-md-3 mb-2">
                                            <label for="start_date" class="sr-only">Fecha de inicio</label>
                                            <input type="date" name="start_date" class="form-control"
                                                placeholder="Fecha de inicio">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="end_date" class="sr-only">Fecha de fin</label>
                                            <input type="date" name="end_date" class="form-control"
                                                placeholder="Fecha de fin">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="docnum" class="sr-only">Documento</label>
                                            <input type="text" name="docnum" class="form-control"
                                                placeholder="Número de documento">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- Indicador de carga -->
                            </ul>
                        </div>
                    </div>

                </nav>

                <br>
                <div id="indicador" class="d-none text-center">
                    <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-2"></i>
                    <p class="mb-0">Cargando...</p>
                </div>
              

                    <div class="card-body">

                        <div class="row">

                            <!-- Columna para encabezados -->
                            <div class="col-md-12">
                                <table class="table table-bordered" id="ventas-table">
                                    <thead>
                                        <tr>
                                            <th>Número de pedido</th>
                                            <!-- <th>Número de Solicitud de compra</th> -->
                                            <!-- <th>Departamento</th>
                                            <th>Persona solicitante</th> -->
                                            <th>Fecha de contabilización</th>
                                            <th>Código de Proveedor</th>
                                            <th>Nombre de Proveedor</th>
                                            <th>Total del Documento</th>
                                            <th>Direccion de destino</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="encabezados-body">
                                        <!-- Aquí se mostrarán los datos de encabezados -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Columna para líneas -->
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                          
                                            <th>Código del Artículo</th>
                                            <th>Descripción del Artículo</th>
                                            <th>Centro Operaciones</th>
                                            <th>Departamento</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody id="lineas-body">
                                        <!-- Aquí se mostrarán los datos de líneas -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="grafico-container">
                            <canvas id="ventas-grafico"></canvas>
                        </div>
                    </div>
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
    $('form').submit(function(event) {
        event.preventDefault();

        const startDate = $('input[name="start_date"]').val();
        const endDate = $('input[name="end_date"]').val();
        const docnum = $('input[name="docnum"]').val();

        if (!startDate && !endDate && !docnum) {
            Swal.fire({
                icon: 'info',
                title: 'Sin Criterios de Búsqueda',
                text: 'Por favor ingrese al menos un criterio de búsqueda.',
            });
            return;
        }

        // Obtén el token de autenticación desde el elemento meta en tu página (debes incluirlo en tu página)
        const token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '{{ url("api/ConsultapedidosCompraSAP") }}',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                docnum: docnum,
            },
            beforeSend: function(xhr) {
                // Agrega el token al encabezado de la solicitud
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                $('#indicador').removeClass('d-none');
            },
            success: function(data) {
                $('#indicador').addClass('d-none');
                const encabezadosBody = $('#encabezados-body');
                const lineasBody = $('#lineas-body');
                encabezadosBody.empty();
                lineasBody.empty();

                if (Array.isArray(data) && data.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin Resultados',
                        text: 'No se encontraron pedidos en SAP.',
                    });
                    return;
                }

                if (typeof data === 'object' && data.hasOwnProperty('DocNum')) {
                    const venta = data;
                    const lines = venta.LineItems;

                    // Llenar tabla de encabezados
                    const encabezadosRow = `
                            <tr>
                                <td>${venta.DocNum}</td>
                                <td>${venta.DocDate}</td>
                                <td>${venta.CardCode}</td>
                                <td>${venta.CardName}</td>
                                <td>${(venta.DocTotal).toLocaleString('es-CO', { style: 'currency', currency: 'COP' })}</td>
                                <td>${venta.Address2}</td>
                            </tr>`;
                    encabezadosBody.append(encabezadosRow);

                    // Llenar tabla de líneas
                    lines.forEach(function(line) {
                        const lineRow = `
                                <tr>
                                    <td>${line.ItemCode}</td>
                                    <td>${line.ItemDescription}</td>
                                    <td>${line.CostingCode}</td>
                                    <td>${line.CostingCode4}</td>
                                </tr>`;
                        lineasBody.append(lineRow);
                    });
                }

                // Inicializa DataTables después de agregar los datos
                $('#encabezados-table').DataTable();
                $('#lineas-table').DataTable();

                Swal.fire({
                    icon: 'success',
                    title: 'Consulta Exitosa',
                    text: 'Los resultados se han cargado correctamente.',
                });

                // Cerrar automáticamente la alerta de éxito después de 1000 milisegundos (1 segundo)
                setTimeout(function() {
                    Swal.close();
                }, 70);
            },
            error: function(error) {
                $('#indicador').addClass('d-none');
                console.error('Error en la consulta AJAX:', error);
                console.log(error.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error en la Consulta',
                    text: 'Ha ocurrido un error al cargar los resultados.',
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
#ventas-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#ventas-table th,
#ventas-table td {
    border: 1px solid #ced4da;
    padding: 8px;
    text-align: center;
}

#ventas-table th {
    background-color: #007bff;
    color: #fff;
}

#ventas-table tr:hover {
    background-color: #f1f1f1;
}

.indicador {
    background-color: white;
}
</style>