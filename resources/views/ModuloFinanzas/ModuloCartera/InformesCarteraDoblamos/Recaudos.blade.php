@extends('layouts.dashboard')

@section('template_title')


@section('content')


<head>
    <!-- Incluir hoja de estilos y librería de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha384-VzLXTJGPSyTLX6d96AxgkKvE/LRb7ECGyTxuwtpjHnVWVZs2gp5RDjeM/tgBnVdM" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-RFZC58YeKApoNsIbBxf4z6JJXmh+geBSgkCQXFyh+4tiFSJmJBt+2FbjxW7Ar16M" crossorigin=""></script>
</head>
<div class="container-fluid">


    <div class="card">
        <div class="container-fluid">

            <div class="card">
                <!-- <div class="row">

            <div class="col-md-12">
                <div style=" background-color: #3d444412;text-align:center ">
                <h5>Recaudos Mes</h5>
                </div>

                <br>
                <div>
                    <canvas id="recaudosChart" width="100" height="29"></canvas>
                </div>
                <br>
                <table class="table table-bordered table-striped" id="CotizacionesOrigenTabla">
                    <thead class="table-info">
                        <tr>
                            <th>Origen</th>
                            <th>Mes</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table> 

            </div>
        </div>  -->

                <div class="row">
                    <div class="col-md-12">
                        <div style="background-color: #3d444412; text-align:center">
                            <h5><b>INFORME POR EDADES</b></h5>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Desde-Hasta</span>
                            <input type="date" aria-label="" class="form-control" id="fechaInicioedades">
                            <input type="date" aria-label="" class="form-control" id="fechaFinedades">
                            <button class="btn btn-primary" id="btnbuscarinfedades">Buscar</button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="informeedades">
                                <thead class="table-info">
                                    <tr>
                                        <th style="font-size: 11px">ESTADO</th>
                                        <th style="font-size: 11px">SUMA DE 0-30</th>
                                        <th style="font-size: 11px">SUMA DE 31-60</th>
                                        <th style="font-size: 11px">SUMA DE 61-90</th>
                                        <th style="font-size: 11px">SUMA DE 91-120</th>
                                        <th style="font-size: 11px">SUMA DE 121-150</th>
                                        <th style="font-size: 11px">SUMA DE 151-180</th>
                                        <th style="font-size: 11px">SUMA >180</th>
                                        <th style="font-size: 11px">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="informeedades">
                                    <!-- Aquí puedes agregar filas de datos si es necesario -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <BR>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div style="background-color: #3d444412; text-align:center">
                        <h5><b>RECAUDOS</b></h5>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Desde-Hasta</span>
                        <input type="date" aria-label="FECH_DOC" class="form-control" id="fechaInicio">
                        <input type="date" aria-label="FECH_DOC" class="form-control" id="fechaFin">
                        <button class="btn btn-primary" id="btnBuscar">Buscar</button>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="ventasAsesorMes">
                            <thead class="table-info">
                                <tr>
                                    <th style="font-size: 11px">DOCUMENTO</th>
                                    <th style="font-size: 11px">ASESOR</th>
                                    <th style="font-size: 11px">FACTURA</th>
                                    <th style="font-size: 11px">REF</th>
                                    <th style="font-size: 11px">F. FACTURA</th>
                                    <th style="font-size: 11px">F. DOCUMENTO</th>
                                    <th style="font-size: 11px">F VENCIMIENTO</th>
                                    <th style="font-size: 11px">PAGO</th>
                                    <th style="font-size: 11px">RECIBO</th>
                                    <th style="font-size: 11px">FECHA DEL PAGO</th>
                                    <th style="font-size: 11px">FECHA VENCIMIENTO PAGO</th>
                                    <th style="font-size: 11px">CODIGO CLIENTE</th>
                                    <th style="font-size: 11px">NOMBRE CLIENTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí puedes agregar filas de datos si es necesario -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </div>


    <div id="loading-overlays" class="loading-overlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-pulse"></i>
            <span>Consultando Recaudos...</span>
        </div>
    </div>

</div>




@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>


@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  $(document).ready(function() {
    // Obtener las fechas seleccionadas
    function obtenerFechas() {
        var fechaInicio = $('#fechaInicio').val();
        var fechaFin = $('#fechaFin').val();
        return {
            fechaInicio: fechaInicio,
            fechaFin: fechaFin
        };
    }

    // Función para mostrar el spinner
    function mostrarSpinner() {
        $("#loading-overlays").show();
    }

    // Función para ocultar el spinner
    function ocultarSpinner() {
        $("#loading-overlays").hide();
    }

    // Función para actualizar la tabla y el gráfico
    function actualizarTablaYGrafico() {
        var fechas = obtenerFechas();

        // Mostrar el spinner antes de la solicitud
        mostrarSpinner();

        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/consumir-recaudos-sap',
            type: 'GET',
            data: fechas,
            success: function(data) {
                ocultarSpinner();

                // Actualizar la tabla
                $('#ventasAsesorMes tbody').empty();
                $.each(data.value, function(index, row) {
                    var newRow = '<tr>' +
                        '<td style="font-size: 12px">' + row.DOCUMENTO + '</td>' +
                        '<td style="font-size: 12px">' + row.SlpName + '</td>' +
                        '<td style="font-size: 12px"><a href="tu_enlace_aqui">' + row.FACT + '</a></td>' +
                        '<td style="font-size: 12px">' + row.REF + '</td>' +
                        '<td style="font-size: 12px">' + row.FECH_FACT + '</td>' +
                        '<td style="font-size: 12px">' + row.FECH_DOC + '</td>' +
                        '<td style="font-size: 12px">' + row.FECH_VEN + '</td>' +
                        '<td style="font-size: 12px">' + row.PAGO + '</td>' +
                        '<td style="font-size: 12px"><a href="tu_enlace_aqui">' + row.RECIBO + '</a></td>' +
                        '<td style="font-size: 12px">' + row.FECH_PAGO + '</td>' +
                        '<td style="font-size: 12px">' + row.FECH_VENPAGO + '</td>' +
                        '<td style="font-size: 12px">' + row.CODSN + '</td>' +
                        '<td style="font-size: 12px">' + row.NOMSN + '</td>' +
                        '</tr>';

                    $('#ventasAsesorMes tbody').append(newRow);
                });

                // Sumar los pagos
                var totalPagos = data.totalPagos;

                // Agregar la fila de totalPagos al final de la tabla
                var totalRow = '<tr>' +
                    '<td colspan="7" style="text-align: right; font-weight: bold;">Total Pagos:</td>' +
                    '<td style="font-size: 12px; font-weight: bold; background-color: #D0F5A9;">' + formatearMoneda(totalPagos) + '</td>' +
                    '<td colspan="5"></td>' +
                    '</tr>';

                $('#ventasAsesorMes tbody').append(totalRow);

                // Actualizar el gráfico
                actualizarGrafico(data);
            },
            error: function(error) {
                console.log(error);
                ocultarSpinner();
            }
        });
    }

    // Función para actualizar el gráfico
    // Función para formatear números como moneda colombiana
    function formatearMoneda(valor) {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 2
        }).format(valor);
    }

    // Función para actualizar el gráfico
    function actualizarGrafico(data) {
        console.log("Updating chart with data:", data);
        var ctx = document.getElementById('recaudosChart').getContext('2d');

        // Agrupar datos por mes y calcular la suma de pagos
        var pagosPorMes = {};
        data.value.forEach(function(row) {
            var mes = row.FECH_DOC.substring(0, 7); // Tomar el año y mes
            pagosPorMes[mes] = (pagosPorMes[mes] || 0) + parseFloat(row.PAGO);
        });

        // Extraer etiquetas y datos para el gráfico
        var meses = Object.keys(pagosPorMes);
        var pagosSumados = Object.values(pagosPorMes);

        var chartData = {
            labels: meses,
            datasets: [{
                label: 'Recaudos',
                backgroundColor: ['#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37', '#9B59B6', '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'],
                borderColor: ['#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37', '#9B59B6', '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'],
                borderWidth: 1,
                data: pagosSumados,
            }],
        };

        var config = {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Utilizar la función de formateo personalizado dividiendo por 1000
                            callback: function(value, index, values) {
                                // Dividir por 1000 y luego formatear como moneda
                                return formatearMoneda(value / 1000);
                            },
                        },
                    },
                },

                plugins: {
                    tooltip: {
                        // Utilizar la función de formateo personalizado
                        callbacks: {
                            label: function(context) {
                                return 'Recaudo: ' + formatearMoneda(context.raw);
                            },
                        },
                    },
                    // Formatear la etiqueta de la barra de herramientas
                    datalabels: {
                        formatter: function(value, context) {
                            return formatearMoneda(value);
                        },
                    },
                },
            },
        };

        var myChart = new Chart(ctx, config);
    }

    // Manejar el evento de clic en el botón Buscar
    $('#btnBuscar').on('click', function() {
        actualizarTablaYGrafico();
    });
});
</script>


<script>
    $(document).ready(function() {
        $('#btnbuscarinfedades').click(function() {
            var fechaInicio = $('#fechaInicioedades').val();
            var fechaFin = $('#fechaFinedades').val();

            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/Indicadores-edades',
                method: 'GET',
                data: {
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Limpiar tbody antes de agregar nuevos datos
                    $('#informeedades tbody').empty();

                    // Verificar los datos recibidos en la consola
                    console.log('Datos recibidos:', response);

                    // Iterar sobre los resultados y agregar filas a la tabla
                    $.each(response.informe, function(index, fila) {
                        var nuevaFila = '<tr>' +
                            '<td>' + fila.Estado_Documento + '</td>' +
                            '<td>' + Number(fila.suma_0_30).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.suma_31_60).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.suma_61_90).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.suma_91_120).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.suma_121_150).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.suma_151_180).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.suma_mas_180).toLocaleString() + '</td>' +
                            '<td>' + Number(fila.total_saldos).toLocaleString() + '</td>' +
                            '</tr>';

                        $('#informeedades tbody').append(nuevaFila);
                    });

                    // Después de iterar sobre los resultados y agregar filas a la tabla
                    // Calcula los totales de cada columna
                    var totalSuma0_30 = 0;
                    var totalSuma31_60 = 0;
                    var totalSuma61_90 = 0;
                    var totalSuma91_120 = 0;
                    var totalSuma121_150 = 0;
                    var totalSuma151_180 = 0;
                    var totalSumaMas180 = 0;
                    var totalSaldos = 0;

                    $.each(response.informe, function(index, fila) {
                        // Sumar los valores para los totales
                        totalSuma0_30 += parseFloat(fila.suma_0_30);
                        totalSuma31_60 += parseFloat(fila.suma_31_60);
                        totalSuma61_90 += parseFloat(fila.suma_61_90);
                        totalSuma91_120 += parseFloat(fila.suma_91_120);
                        totalSuma121_150 += parseFloat(fila.suma_121_150);
                        totalSuma151_180 += parseFloat(fila.suma_151_180);
                        totalSumaMas180 += parseFloat(fila.suma_mas_180);
                        totalSaldos += parseFloat(fila.total_saldos);
                    });

                    // Agregar fila con totales al final de la tabla
                    var filaTotales = '<tr>' +
                        '<td><b>TOTAL</b></td>' +
                        '<td><b>' + totalSuma0_30.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSuma31_60.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSuma61_90.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSuma91_120.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSuma121_150.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSuma151_180.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSumaMas180.toLocaleString() + '</b></td>' +
                        '<td><b>' + totalSaldos.toLocaleString() + '</b></td>' +
                        '</tr>';

                    // Agregar fila con totales al final de la tabla
                    $('#informeedades tbody').append(filaTotales);
                },
                error: function(error) {
                    // Maneja errores si es necesario
                    console.error(error);
                }
            });
        });
    });
</script>




<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    .bg-header {
        color: grey;
        text-align: center;
        padding: 1em 0;
        border-radius: 10px 10px 0 0;
    }

    .inventory-section,
    .mrp-section {
        margin: 20px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
    }

    .btn-asistente {
        background-color: grey;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        cursor: pointer;
    }



    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }


    .full-height {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .flex-grow {
        flex-grow: 1;
    }

    /* Estilos para el indicador de carga */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 1000;
    }

    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .loading-spinner i {
        font-size: 40px;
        color: #0056b3;
    }

    .loading-spinner span {
        display: block;
        font-size: 18px;
        margin-top: 10px;
    }

    .btn-asistente {
        background-color: #0056b3;
    }
</style>