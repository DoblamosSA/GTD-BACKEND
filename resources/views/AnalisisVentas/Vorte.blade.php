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
                        <a class="navbar-brand" href="#">ANALISIS VENTA VORTEX SAP</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">

                                <form action="{{ url('api/Analisisventavorte') }}" method="get" class="form-inline">
                                    <div class="form-group">
                                       
                                        <input type="date" name="start_date" class="form-control mr-2">
                                
                                        <input type="date" name="end_date" class="form-control mr-2">
                                
                                        <input type="text"  placeholder="Nit Cliente" name="card_code" class="form-control mr-2">
                                        <button type="submit" class="btn btn-primary">Buscar</button>
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
                    <!-- Tabla para mostrar los resultados de la consulta -->
                    <div class="table-responsive">
                    <table class="table " id="ventas-table">
                            <thead>
                                <tr>
                                    <th>CardCode</th>
                                    <th>CardName</th>
                                    <th>Total antes del descuento</th>
                                    <th>Impuesto</th>
                                    <th>ValorTotal</th>
                                    <th>DocNum</th>
                                    <th>Kg Vendidos</th>
                                    <th>TipoDoc</th>
                                    <th>DocDate</th>
                                    <th>DocDueDate</th>
                                    <th>Centro Operaciones</th>
                                    <th>Centro Costo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí mostraremos los resultados de la consulta -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Contenedor para el gráfico -->
                    <div class="col-sm-12">
                        <div class="grafico-container">
                            <canvas id="ventas-grafico"></canvas>
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
    // Escuchar el evento submit del formulario
    $('form').submit(function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe normalmente

        // Obtener los valores de las fechas y el CardCode
        const startDate = $('input[name="start_date"]').val();
        const endDate = $('input[name="end_date"]').val();
        const cardCode = $('input[name="card_code"]').val();

        // Realizar la solicitud AJAX
        $.ajax({
            url: '{{ url("api/Analisisventavorte") }}',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                CardCode: cardCode // Agregar el CardCode a los datos enviados
            },
            beforeSend: function() {
                // Mostrar el indicador de carga antes de la solicitud AJAX
                $('#indicador').removeClass('d-none');
            },
            success: function(data) {
                // Ocultar el indicador después de obtener los datos
                $('#indicador').addClass('d-none');

                // Actualizar la tabla con los resultados de la consulta
                const tbody = $('#ventas-table tbody');
                tbody.empty(); // Limpiar el contenido actual de la tabla

                // Crear un objeto para almacenar los datos agregados por DocNum
                const groupedData = groupDataByDocNumAndSum(data);

                // Agregar cada fila de datos a la tabla
                groupedData.forEach(function(venta) {
                    const formattedValorIva = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP'
                    }).format(venta.ValorIva);

                    const formattedValorSinIva = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP'
                    }).format(venta.ValorSinIva); // Nuevo campo para valor sin IVA

                    const formattedValorTotal = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP'
                    }).format(venta.ValorTotal);

                    const row = `<tr>
                        <td>${venta.CardCode}</td>
                        <td>${venta.CardName}</td>
                        <td>${formattedValorSinIva}</td> <!-- Mostrar valor sin IVA -->
                        <td>${formattedValorIva}</td>
                        <td>${formattedValorTotal}</td>
                        <td>${venta.DocNum}</td>
                        <td>${venta.Kg_Vendidos}</td>
                        <td>${venta.TipoDoc}</td>
                        <td>${venta.DocDate}</td>
                        <td>${venta.DocDueDate}</td>
                        <td>${venta.Centro_Operaciones}</td>
                        <td>${venta.Centro_Costo}</td>
                    </tr>`;
                    tbody.append(row);
                });

                // Inicializar DataTables después de agregar los datos a la tabla
                $('#ventas-table').DataTable({
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    language: {
                        paginate: {
                            previous: '&laquo;', // Reemplaza el texto "Previous" por "«"
                            next: '&raquo;' // Reemplaza el texto "Next" por "»"
                        }
                    }
                });

                // Generar el gráfico con Chart.js
                generarGrafico(groupedData);
            },
            error: function(error) {
                // Ocultar el indicador en caso de error
                $('#indicador').addClass('d-none');

                // Mostrar mensaje de error si la consulta falla
                console.error('Error en la consulta AJAX:', error);
                alert('Ocurrió un error al obtener los datos de ventas.');
            }
        });
    });

    function generarGrafico(data) {
        const ctx = document.getElementById('ventas-grafico').getContext('2d');

        // Obtener los datos necesarios para el gráfico
        const labels = data.map(venta => venta.CardName);
        const valores = data.map(venta => venta.ValorTotal);

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventas',
                    data: valores,
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function groupDataByDocNumAndSum(data) {
    const groupedData = {};
    data.forEach(function(venta) {
        if (groupedData[venta.DocNum]) {
            // Sumar los campos ValorIva y Kg_Vendidos si el DocNum es el mismo
            groupedData[venta.DocNum].ValorTotal += venta.ValorTotal;
            groupedData[venta.DocNum].ValorIva += venta.ValorIva;
            groupedData[venta.DocNum].Kg_Vendidos += venta.Kg_Vendidos;
            // Corregir el cálculo del valor sin IVA
            groupedData[venta.DocNum].ValorSinIva = groupedData[venta.DocNum].ValorTotal - groupedData[venta.DocNum].ValorIva;
        } else {
            groupedData[venta.DocNum] = {
                ...venta,
                ValorSinIva: venta.ValorTotal - venta.ValorIva 
            };
        }
    });

        
        // Redondear los valores de Kg_Vendidos a 2 decimales
        Object.values(groupedData).forEach(function(venta) {
            venta.Kg_Vendidos = parseFloat(venta.Kg_Vendidos.toFixed(2));
        });
        return Object.values(groupedData);
    }
});
</script>

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
@endsection