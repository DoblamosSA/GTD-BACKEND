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
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <form action="" method="get" class="form-inline">
                            <div class="form-group">
                                <label for="start_date" class="mr-2">Desde:</label>
                                <input type="date" name="start_date" class="form-control mr-2">
                                <label for="end_date" class="mr-2">Hasta:</label>
                                <input type="date" name="end_date" class="form-control mr-2">
                                <label for="card_code" class="mr-2">CardCode:</label>
                                <input type="text" name="card_code" class="form-control mr-2">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </form>
                        <div id="indicador" class="d-none"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table " id="ventas-table">
                            <thead>
                                <tr>
                                    <th>Fecha contabilización</th>
                                    <th>Numero Documento pedido</th>
                                    <th>Numero Documento Solicitud</th>
                                    <th>Nombre Solicitante</th>
                                    <th>Valor Antes Iva</th>
                                    <th>ValorTotal</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí mostraremos los resultados de la consulta -->
                            </tbody>
                        </table>
                    </div>
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
</div>
</div>
@endsection

@section('scripts')
<!-- Asegúrate de agregar Chart.js en el encabezado -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

@endsection
<style>
.btn-estado {
    width: 150px;
    /* ajustar el ancho según sus necesidades */
}

/* Estilos para la sección del gráfico */
#grafico-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    width: 100%;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
}

/* Estilos para el contenedor de la tabla */
#tabla-container {
    padding: 20px;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
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
</style>