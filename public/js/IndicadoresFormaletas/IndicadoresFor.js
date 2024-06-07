
//select 2 para buscar facilmente los asesores
$(document).ready(function() {
    $('#asesoresDoblamos').select2();
  });
  



//cotizaciones en seguimiento grafico->

$(document).ready(function() {
    var chart = null;

    // Cargar ventas_mes inicialmente
    cargarVentasMes();

    // Manejar cambio de opción en el select
    $('#seguimientoano').change(function() {
        cargarVentasMes();
    });

    function cargarVentasMes() {
        var anios = $('#seguimientoano').val();
        var url = 'https://rdpd.sagerp.co:59881/gestioncalidad/public/ventas-mes-seguimientoFor-ajax/' + anios;

        $.ajax({
            url: url,
            success: function(data) {
                // Vaciar tabla y agregar datos de ventas_mes
                $('#ventas-mes-seguimiento').DataTable().destroy(); // Destruye la instancia anterior de DataTables si existe.
                $('#ventas-mes-seguimiento tbody').empty();
                data.forEach(function(venta) {
                    var row = $('<tr>');
                    row.append($('<td>').text(moment(venta.mes + '-01').locale('es').format('MMMM')));

                    var formattedTotal = Number(venta.total).toLocaleString('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    });
                    row.append($('<td>').text(formattedTotal));
                    $('#ventas-mes-seguimiento tbody').append(row);
                });

                // Inicializa la tabla como un DataTable
                $('#ventas-mes-seguimiento').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "order": [[ 0, "desc" ]]
                });

                // Destruir instancia del gráfico anterior si existe
                if (chart !== null) {
                    chart.destroy();
                }

                // Crear gráfica de ventas mensuales en seguimiento 
                var ctx = document.getElementById('ventas-seguimiento-grafica').getContext('2d');
                var colors = ['#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37', '#9B59B6', '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'];

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(function(venta) {
                            return moment(venta.mes + '-01').format('MMMM');
                        }),
                        datasets: [{
                            label: 'Ocultar',
                            data: data.map(function(venta) {
                                return venta.total;
                            }),
                            backgroundColor: data.map(function(venta, index) {
                                return colors[index % colors.length];
                            }),
                            borderColor: '#FF5733',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function (value, index, values) {
                                        // Eliminar los ceros en el eje Y y aplicar formato de moneda
                                        if (value >= 1000000) {
                                            return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                                        } else if (value >= 1000) {
                                            return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                                        } else {
                                            return value.toLocaleString('es-CO', {
                                                style: 'currency',
                                                currency: 'COP',
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return value.toLocaleString('es-CO', {
                                        style: 'currency',
                                        currency: 'COP',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    }
                });
            }
        });
    }
});



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// grafico Ventas Mes

  $(document).ready(function() {
    // Obtener los datos y dibujar el gráfico inicialmente
    var chart = null;
    var tabla;
    var anioSeleccionado = '';

    dibujarGrafico();

    // Función que se ejecuta al cambiar el valor del select
    $('#anio').change(function() {
        dibujarGrafico();
    });

    function dibujarGrafico() {
        // Obtener el año seleccionado en el select
        var anio = $('#anio').val();

        // Verificar si el año seleccionado ha cambiado
        if (anio !== anioSeleccionado) {
            // Actualizar la variable de año seleccionado
            anioSeleccionado = anio;

            // Obtener los datos
            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/ventas-mes-ajaxFor/' + anio,
                success: function(data) {
                    // Destruir instancia del gráfico anterior si existe
                    if (chart !== null) {
                        chart.destroy();
                    }

                    // Crear gráfica de ventas mensuales
                    var ctx = document.getElementById('ventas-mes-chart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(function(venta) {
                                return moment(venta.mes + '-01').format('MMMM');
                            }),
                            datasets: [{
                                label: 'Ocultar',
                                data: data.map(function(venta) {
                                    return venta.total;
                                }),
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                // Agregar función para formatear los valores en las etiquetas de la gráfica
                                datalabels: {
                                    formatter: function(value, context) {
                                        return formatoMoneda(value);
                                    }
                                }
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value, index, values) {
                                            return formatoMoneda(value);
                                        }
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'end',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                        return formatoMoneda(value);
                                    }
                                }
                            }
                        }
                    });
                    // Función para formatear los valores en formato de moneda
                    function formatoMoneda(value) {
                        if (value >= 1000000) {
                            return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                        } else if (value >= 1000) {
                            return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                        } else {
                            return value.toLocaleString('es-CO', {
                                style: 'currency',
                                currency: 'COP',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                  
                    // Destruir la instancia existente de DataTables si existe
                    if (tabla) {
                        tabla.destroy();
                    }

                    // Limpiar la tabla
                    $('#ventas-mes tbody').empty();

                    // Agregar datos a la tabla
                    data.forEach(function(venta) {
                        var row = $('<tr>');
                        row.append($('<td>').text(moment(venta.mes + '-01').format('MMMM')));
                        var formattedTotal = formatoMoneda(venta.total);
                        row.append($('<td>').text(formattedTotal));
                        $('#ventas-mes tbody').append(row);
                    });

                    // Inicializar DataTables después de cargar los datos en la tabla
                    tabla = $('#ventas-mes').DataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en AJAX: ' + errorThrown);
                }
            });
        }
    }

    function formatoMoneda(valor) {
        return Number(valor).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }
});


// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7


// //Ventas por tipología 


$(document).ready(function() {
    cargarVentasMesTipologia();

    $('#select-ano, #select-tipologia').change(cargarVentasMesTipologia);
});

function cargarVentasMesTipologia() {
    var anio = $('#select-ano').val();
    var tipologia = $('#select-tipologia').val();
    var url = 'https://rdpd.sagerp.co:59881/gestioncalidad/public/ventas-mes-tipologia-ajaxforma/' + anio + '/' + tipologia;

    $.ajax({
        url: url,
        success: function(data) {
            // Obtener los datos de meses y ventas
            var meses = data.map(function(venta) {
                return moment(venta.mes + '-01', 'M').locale('es').format('MMMM');
            });
            var ventas = data.map(function(venta) {
                return parseFloat(venta.total).toFixed(2); // Convertir a número y limitar a 2 decimales
            });

            // Colores personalizados para las barras
            var colores = ['#DF6811', '#1146DF', '#B3B4B6'];

            // Crear el array de colores
            var coloresBarras = [];
            for (var i = 0; i < meses.length; i++) {
                var color = colores[i % colores.length];
                coloresBarras.push(color);
            }

            // Renderizar el gráfico
            const ctx = document.getElementById('vntaTipologia').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Ventas por tipología y año',
                        data: ventas,
                        backgroundColor: coloresBarras, // Colores de las barras
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function (value) {
                                    // Eliminar los ceros en el eje Y
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                                    } else {
                                        return value;
                                    }
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel.toLocaleString('es-CO', {
                                    style: 'currency',
                                    currency: 'COP'
                                });
                            }
                        }
                    }
                }
                
            });

            // Actualizar la tabla con los datos
            var cotizacionesTipologiaTable = $('#cotizaciones-tipologia').DataTable();
            cotizacionesTipologiaTable.clear().draw();

            data.forEach(function(venta) {
                var rowData = [
                    moment(venta.mes + '-01').locale('es').format('MMMM'),
                    Number(venta.total).toLocaleString('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    })
                ];
                cotizacionesTipologiaTable.row.add(rowData);
            });

            cotizacionesTipologiaTable.draw();

            // Actualizar el gráfico cuando se haga clic en una barra
            chart.options.onClick = function(event, elements) {
                if (elements.length > 0) {
                    var dataIndex = elements[0].index;
                    var mes = data[dataIndex].mes;
                    var valor = data[dataIndex].total;

                    $('#cotizaciones-tipologia tbody tr').removeClass('selected');
                    $('#cotizaciones-tipologia tbody tr:eq(' + dataIndex + ')').addClass('selected');

                    // Actualizar otros elementos de la página con los datos seleccionados
                    // ...
                }
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error en AJAX: ' + errorThrown);
        }

    });
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// // grafico de cotizaciones por tipologia en seguimiento 


$(document).ready(function() {
    cargarVentasMesTipologiaSeguimiento();

    $('#anioseg, #select-cotizacionseguimiento').change(cargarVentasMesTipologiaSeguimiento);
});

function cargarVentasMesTipologiaSeguimiento() {
    var anio = $('#anioseg').val();
    var tipologiaseguimiento = $('#select-cotizacionseguimiento').val();
    var url = 'https://rdpd.sagerp.co:59881/gestioncalidad/public/coti-mes-tipologia-seguimiforaletas-ajax/' + anio + '/' + tipologiaseguimiento;

    $.ajax({
        url: url,
        success: function(data) {
            // Obtener los datos de meses y ventas
            var meses = data.map(function(venta) {
                return moment(venta.mes + '-01', 'M').locale('es').format('MMMM');
            });
            var ventas = data.map(function(venta) {
                return venta.total;
            });

            // Colores personalizados para las barras
            var colores = ['#DF6811', '#1146DF', '#B3B4B6','#FF5733','#F0FF33','#47473E','#3E4747','#140317'];

            // Crear el array de colores
            var coloresBarras = [];
            for (var i = 0; i < meses.length; i++) {
                var color = colores[i % colores.length];
                coloresBarras.push(color);
            }

            // Renderizar el gráfico
            const ctx = document.getElementById('GraficoVentasSeguimientoTipologia').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Ventas por tipología en seguimiento',
                        data: ventas,
                        backgroundColor: coloresBarras, // Colores de las barras
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

            // Actualizar la tabla con los datos
            var cotizacionesTipologiaseguimientoTable = $('#VentasSeguimientotipo').DataTable();
            cotizacionesTipologiaseguimientoTable.clear().draw();

            data.forEach(function(venta) {
                var rowData = [
                    moment(venta.mes + '-01').locale('es').format('MMMM'),
                    Number(venta.total).toLocaleString('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    })
                ];
                cotizacionesTipologiaseguimientoTable.row.add(rowData);
            });

            cotizacionesTipologiaseguimientoTable.draw();

            // Actualizar el gráfico cuando se haga clic en una barra
            chart.options.onClick = function(event, elements) {
                if (elements.length > 0) {
                    var dataIndex = elements[0].index;
                    var mes = data[dataIndex].mes;
                    var valor = data[dataIndex].total;

                    $('#VentasSeguimientotipo tbody tr').removeClass('selected');
                    $('#VentasSeguimientotipo tbody tr:eq(' + dataIndex + ')').addClass('selected');

                    // Actualizar otros elementos de la página con los datos seleccionados
                    // ...
                }
            };

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error en AJAX: ' + errorThrown);
        }

    });
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// //Tendencias de ventas por tipologia 

$(document).ready(function() {
    // Obtener los datos y dibujar el gráfico inicialmente
    var grafico;
    var tabla;

    dibujarGrafico();

    // Función que se ejecuta al cambiar el valor del select
    $('#VentasGeneralesTipologiasanio').change(function() {
        dibujarGrafico();
    });

    function dibujarGrafico() {
        // Obtener el año seleccionado en el select
        var anio = $('#VentasGeneralesTipologiasanio').val();

        // Obtener los datos
        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/VentasGeneralesTipologiaformaletas/' + anio,
            type: 'GET',
            success: function(data) {
                // Transformar los datos en un formato que pueda ser utilizado por Chart.js
                var datos = {};

                data.forEach(function(item) {
                    if (!(item.Tipologia in datos)) {
                        datos[item.Tipologia] = {
                            label: item.Tipologia,
                            data: Array(12).fill(0),
                            backgroundColor: '#' + Math.floor(Math.random() * 16777215).toString(16)
                        };
                    }

                    datos[item.Tipologia].data[item.mes - 1] += item.total;
                });

                // Dibujar el gráfico si es la primera vez o actualizar los datos si ya existe
                var ctx = document.getElementById('VentasGeneralesTipologias').getContext('2d');
                var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

                if (grafico) {
                    grafico.data.labels = meses;
                    grafico.data.datasets = Object.values(datos);
                    grafico.update(); // Actualizar los datos del gráfico
                } else {
                    grafico = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: Object.values(datos)
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value, index, values) {
                                            if (value >= 1000000) {
                                                return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                                            } else if (value >= 1000) {
                                                return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                                            } else {
                                                return value.toLocaleString('es-CO', {
                                                    style: 'currency',
                                                    currency: 'COP',
                                                    minimumFractionDigits: 0,
                                                    maximumFractionDigits: 2
                                                });
                                            }
                                        }
                                    }
                                }]
                            }
                        }
                    });
                }

                // Destruir la instancia existente de DataTables si existe
                if (tabla) {
                    tabla.destroy();
                }

                // Limpiar la tabla
                $('#tablaventastipologiageneral tbody').empty();

                // Recorrer los datos y agregarlos a la tabla
                data.forEach(function(item) {
                    var row = $('<tr></tr>');
                    row.append($('<td></td>').text(item.Tipologia));
                    row.append($('<td></td>').text(meses[item.mes - 1]));
                    row.append($('<td></td>').text(Number(item.total).toLocaleString('es-CO')));

                    $('#tablaventastipologiageneral tbody').append(row);
                });

                // Inicializar DataTables después de cargar los datos en la tabla
                tabla = $('#tablaventastipologiageneral').DataTable({
                    paging: true,
                    searching: true,
                    lengthMenu: [5, 10, 25, 50, 100], // Mostrar las opciones de longitud personalizadas
                    pageLength: 5 // Establecer el valor inicial en 5
                });
            }
        });
    }
});

// /////////////////////////////////////////////////////////////////////////////////////////////////////////////



// // Tendencia de contizaciones por tipología

$(document).ready(function() {
    // Obtener los datos y dibujar el gráfico inicialmente
    var grafico;
    var tabla;
    var anioSeleccionado = '';

    dibujarGrafico();

    // Función que se ejecuta al cambiar el valor del select
    $('#CotizacionesGeneralesTipologiasanio').change(function() {
        dibujarGrafico();
    });

    function dibujarGrafico() {
        // Obtener el año seleccionado en el select
        var anio = $('#CotizacionesGeneralesTipologiasanio').val();

        // Verificar si el año seleccionado ha cambiado
        if (anio !== anioSeleccionado) {
            // Actualizar la variable de año seleccionado
            anioSeleccionado = anio;

            // Obtener los datos
            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/CotizacionesGeneralesTipologiaFormaletas/' + anio,
                type: 'GET',
                success: function(data) {
                    // Transformar los datos en un formato que pueda ser utilizado por Chart.js
                    var datos = {};

                    data.forEach(function(item) {
                        if (!(item.Tipologia in datos)) {
                            datos[item.Tipologia] = {
                                label: item.Tipologia,
                                data: Array(12).fill(0),
                                backgroundColor: '#' + Math.floor(Math.random() * 16777215).toString(16)
                            };
                        }

                        datos[item.Tipologia].data[item.mes - 1] += item.total;
                    });

                    // Dibujar el gráfico si es la primera vez o actualizar los datos si ya existe
                    var ctx = document.getElementById('CotizacionesGeneralesTipologias').getContext('2d');
                    var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

                    if (grafico) {
                        grafico.data.labels = meses;
                        grafico.data.datasets = Object.values(datos);
                        grafico.update(); // Actualizar los datos del gráfico
                    } else {
                        grafico = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: meses,
                                datasets: Object.values(datos)
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                            callback: function(value, index, values) {
                                                if (value >= 1000000) {
                                                    return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                                                } else if (value >= 1000) {
                                                    return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                                                } else {
                                                    return value.toLocaleString('es-CO', {
                                                        style: 'currency',
                                                        currency: 'COP',
                                                        minimumFractionDigits: 0,
                                                        maximumFractionDigits: 2
                                                    });
                                                }
                                            }
                                        }
                                    }]
                                }
                            }
                          
                    });
                    }

                    // Destruir la instancia existente de DataTables si existe
                    if (tabla) {
                        tabla.destroy();
                    }

                    // Limpiar la tabla
                    $('#cotizacionestablaventastipologiageneral tbody').empty();

                    // Recorrer los datos y agregarlos a la tabla
                    data.forEach(function(item) {
                        var row = $('<tr></tr>');
                        row.append($('<td></td>').text(item.Tipologia));
                        row.append($('<td></td>').text(meses[item.mes - 1]));
                        row.append($('<td></td>').text(Number(item.total).toLocaleString('es-CO')));

                        $('#cotizacionestablaventastipologiageneral tbody').append(row);
                    });

                    // Inicializar DataTables después de cargar los datos en la tabla
                    tabla = $('#cotizacionestablaventastipologiageneral').DataTable({
                        paging: true,
                        searching: true
                        });
         }
        });
        }
        }
    });

// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// //Origen de las cotizaciones


$(document).ready(function() {
    // Obtener los datos y dibujar el gráfico inicialmente
    var grafico;
    var tabla;

    dibujarGraficoOrigen();

    // Función que se ejecuta al cambiar el valor del select
    $('#CotizacionesOrigenanio').change(function() {
        dibujarGraficoOrigen();
    });

    function dibujarGraficoOrigen() {
        // Obtener el año seleccionado en el select
        var anio = $('#CotizacionesOrigenanio').val();

        // Obtener los datos
        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/VentasOrigenesFormaletas/' + anio,
            type: 'GET',
            success: function(data) {
                // Transformar los datos en un formato que pueda ser utilizado por Chart.js
                var datos = {};

                data.forEach(function(item) {
                    if (!(item.Origen in datos)) {
                        datos[item.Origen] = {
                            label: item.Origen,
                            data: Array(12).fill(0),
                            backgroundColor: '#' + Math.floor(Math.random() * 16777215).toString(16)
                        };
                    }

                    datos[item.Origen].data[item.mes - 1] += item.total;
                });

                // Dibujar el gráfico si es la primera vez o actualizar los datos si ya existe
                var ctx = document.getElementById('CotizacionesOrigen').getContext('2d');
                var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

                if (grafico) {
                    grafico.data.labels = meses;
                    grafico.data.datasets = Object.values(datos);
                    grafico.update(); // Actualizar los datos del gráfico
                } else {
                    grafico = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: Object.values(datos)
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value, index, values) {
                                            if (value >= 1000000) {
                                                return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                                            } else if (value >= 1000) {
                                                return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                                            } else {
                                                return value.toLocaleString('es-CO', {
                                                    style: 'currency',
                                                    currency: 'COP',
                                                    minimumFractionDigits: 0,
                                                    maximumFractionDigits: 2
                                                });
                                            }
                                        }
                                    }
                                }]
                            }
                        }
                        
                    });
                }

                // Destruir la instancia existente de DataTables si existe
                if (tabla) {
                    tabla.destroy();
                }

                // Limpiar la tabla
                $('#CotizacionesOrigenTabla tbody').empty();

                // Recorrer los datos y agregarlos a la tabla
                data.forEach(function(item) {
                    var row = $('<tr></tr>');
                    row.append($('<td></td>').text(item.Origen));
                    row.append($('<td></td>').text(meses[item.mes - 1]));
                    row.append($('<td></td>').text(Number(item.total).toLocaleString('es-CO')));

                    $('#CotizacionesOrigenTabla tbody').append(row);
                });

                // Inicializar DataTables después de cargar los datos en la tabla
                tabla = $('#CotizacionesOrigenTabla').DataTable({
                    paging: true,
                    searching: true
                });
            }
        });
    }
});

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// //Ventas Internacionales

var map = L.map('map').setView([0, 0], 1);
var selectAnio = document.getElementById('ventaspais');
var tabla;

// Agregar capa de mapa de OpenStreetMap
L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    attribution: '&copy; Google',
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
}).addTo(map);

// Función para obtener las ventas por país
function obtenerVentasPorPais(anio) {
    $.ajax({
        url: '/Ventas-mes-pais-formaletas/' + anio,
        method: 'GET',
        success: function (response) {
            // Limpiar el mapa antes de actualizar los datos
            map.eachLayer(function (layer) {
                if (layer instanceof L.CircleMarker) {
                    map.removeLayer(layer);
                }
            });

            var ventasPorPais = response;
            var nombresPaises = [];
            var ventas = [];

            ventasPorPais.forEach(function (venta) {
                var country = venta.countryName;
                var coordinates = [venta.latitude, venta.longitude];
                var ventaValor = parseFloat(venta.ventas);

                nombresPaises.push(country);
                ventas.push(ventaValor);

                if (coordinates[0] && coordinates[1]) {
                    L.circleMarker(coordinates)
                        .addTo(map)
                        .bindPopup('<b>' + country + '</b><br>Ventas: ' + ventaValor.toLocaleString('es-CO', {
                            style: 'currency',
                            currency: 'COP'
                        }));
                }
            });

            // Generar gráfico de barras
            generarGraficoBarras(nombresPaises, ventas, 'bar-chart');

            // Destruir la instancia existente de DataTables si existe
            if (tabla) {
                tabla.destroy();
            }

            // Limpiar la tabla
            $('#ventas-mes-pais tbody').empty();

            // Recorrer los datos y agregarlos a la tabla
            ventasPorPais.forEach(function (venta) {
                var country = venta.countryName;
                var ventaValor = parseFloat(venta.ventas);

                // Agregar fila a la tabla HTML
                var fila = '<tr><td>' + country + '</td><td>' + ventaValor.toLocaleString('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                }) + '</td></tr>';
                $('#ventas-mes-pais tbody').append(fila);
            });

            // Inicializar DataTables después de cargar los datos en la tabla
            tabla = $('#ventas-mes-pais').DataTable({
                paging: true,
                searching: true
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

// Obtener las ventas por país al cargar la página
obtenerVentasPorPais(selectAnio.value);

// Manejar el evento change del select
selectAnio.addEventListener('change', function () {
    var anioSeleccionado = this.value;
    obtenerVentasPorPais(anioSeleccionado);
});

// Función para generar gráfico de barras
function generarGraficoBarras(nombresPaises, ventas, canvasId) {
    var ctx = document.getElementById(canvasId).getContext('2d');

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nombresPaises,
            datasets: [{
                label: 'Ventas',
                data: ventas,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                            } else {
                                return value.toLocaleString('es-CO', {
                                    style: 'currency',
                                    currency: 'COP',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        var value = tooltipItem.yLabel;
                        if (value >= 1000000) {
                            return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                        } else if (value >= 1000) {
                            return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                        } else {
                            return value.toLocaleString('es-CO', {
                                style: 'currency',
                                currency: 'COP',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                }
            }
        }
    });
}


// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// // Cotizaciones Internacionales en seguimiento

var mapaseguimiento = L.map('cotizacionesSeguimiento').setView([0, 0], 1);
var selectAnio = document.getElementById('ventaspaisseguimiento');
var selectMes = document.getElementById('messeguimiento');
var chart;
var tablaVentas;

// Paleta de colores predefinida
var colorPalette = [
    '#e74c3c', '#8e44ad', '#3498db', '#e67e22', '#2ecc71', '#f1c40f', '#1abc9c',
    '#9b59b6', '#2980b9', '#f39c12', '#27ae60', '#d35400', '#c0392b', '#bdc3c7',
    '#7f8c8d', '#16a085', '#f39c12', '#95a5a6', '#f39c12', '#d35400'
];

// Agregar capa de mapa de OpenStreetMap
L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    attribution: '&copy; Google',
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
}).addTo(mapaseguimiento);

// Función para obtener las ventas por país
function obtenerVentasPorPaisSeguimiento(anio, mes) {
    $.ajax({
        url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/Ventas-mes-pais-seguimiento-forma/' + anio + '/' + mes,
        method: 'GET',
        success: function(response) {
            // Limpiar el mapa y la tabla antes de actualizar los datos
            mapaseguimiento.eachLayer(function(layer) {
                if (layer instanceof L.CircleMarker) {
                    mapaseguimiento.removeLayer(layer);
                }
            });

            // Limpiar la tabla antes de agregar los nuevos datos
            var tablaVentas = $('#ventas-mes-pais-seguimiento').DataTable();
            tablaVentas.clear().draw();

            var ventasPorPais = response;
            var nombresMeses = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];

            ventasPorPais.forEach(function(venta) {
                var country = venta.countryName;
                var coordinates = [venta.latitude, venta.longitude];
                var ventas = parseFloat(venta.ventas);
                var ventasFormateadas = ventas.toLocaleString('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                });
                var mes = nombresMeses[new Date(venta.mes + "/01/2000").getMonth()];

                if (coordinates[0] && coordinates[1]) {
                    L.circleMarker(coordinates)
                        .addTo(mapaseguimiento)
                        .bindPopup('<b>' + country + '</b><br>Ventas: ' + ventasFormateadas);

                    // Agregar fila a la tabla HTML
                    var fila = '<tr><td>' + mes + '</td><td>' + country + '</td><td>' + venta.cotizaciones + '</td><td>' + ventasFormateadas + '</td></tr>';
                    tablaVentas.row.add($(fila)).draw();
                }
            });

            // Obtener los datos necesarios para el gráfico de barras
            var datosVentas = ventasPorPais.map(function(venta) {
                return parseFloat(venta.ventas);
            });

            var nombresPaises = ventasPorPais.map(function(venta) {
                return venta.countryName;
            });

            // Actualizar el gráfico de barras
            actualizarGraficoBarras(datosVentas, nombresPaises);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


function actualizarGraficoBarras(datosVentas, nombresPaises) {
    if (chart) {
        chart.destroy();
    }

    // Formatear los valores de ventas en pesos colombianos
    var ventasFormateadas = datosVentas.map(function(venta) {
        return venta.toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP'
        });
    });

    // Configurar el gráfico de barras
    var ctx = document.getElementById('graficoBarrasSeguimiento').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nombresPaises,
            datasets: [{
                label: 'Cotizaciones',
                data: datosVentas,
                backgroundColor: colorPalette.slice(0, nombresPaises.length)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                            } else {
                                return value.toLocaleString('es-CO', {
                                    style: 'currency',
                                    currency: 'COP',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }]
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var value = context.dataset.data[context.dataIndex];
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                            } else {
                                return value.toLocaleString('es-CO', {
                                    style: 'currency',
                                    currency: 'COP',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }
            }
        }
    });
}    

// Obtener las ventas por país al cargar la página
obtenerVentasPorPaisSeguimiento(selectAnio.value, selectMes.value);

// Manejar el evento change del select de año
selectAnio.addEventListener('change', function() {
    var anioSeleccionado = selectAnio.value;
    var mesSeleccionado = selectMes.value;
    obtenerVentasPorPaisSeguimiento(anioSeleccionado, mesSeleccionado);
});

// Manejar el evento change del select de mes
selectMes.addEventListener('change', function() {
    var anioSeleccionado = selectAnio.value;
    var mesSeleccionado = selectMes.value;
    obtenerVentasPorPaisSeguimiento(anioSeleccionado, mesSeleccionado);
});



// // Obtiene los datos de los costos de calidad para formaletas

window.onload = function() {
    obtenerCostosCalidad(anio.value);
};
var anio = document.getElementById('aniocostocalidad');

function obtenerCostosCalidad(anio) {
    $.ajax({
        url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/Costos-nocalidad-formaletas/' + anio,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Actualiza el gráfico con los datos obtenidos
            actualizarGrafico(data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Actualiza el gráfico con los datos obtenidos del servidor
function actualizarGrafico(datos) {
    // Obtiene los valores para los meses y los costos
    var meses = [];
    var costos = [];
    const esLocale = {
        month: 'long',
    };
    datos.forEach(function(item) {
        var fecha = moment(item.mes_alias + '-01');
        meses.push(fecha.locale('es').format('MMMM'));
        costos.push(item.total);
    });

    // Crea el gráfico
    var ctx = document.getElementById('GraficoCostosCalidad').getContext('2d');
    var grafico = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: meses,
            datasets: [{
                data: costos,
                borderWidth: 1,
                backgroundColor: colorPalette,
            }]
        },
       
    });
    // Agrega los valores a la tabla
    var tabla = $('#Costoscalidad tbody');
    tabla.empty();
    for (var i = 0; i < meses.length; i++) {
        var fecha = moment(meses[i], 'MMMM');
        tabla.append($('<tr>').append($('<td>').text(fecha.format('MMMM')))
            .append($('<td>').text(parseFloat(costos[i]).toLocaleString('es-CO', {
                style: 'currency',
                currency: 'COP'
            }))));
    }
}
// Llama a la función para obtener los datos de los costos de calidad
obtenerCostosCalidad();






// //ventas Mensuales por asesor
$(document).ready(function() {
    // Cargar indicador al cargar la página
    cargarIndicador();

    // Detectar cambios en los selects
    $('#ventasasesoranio, #mesasesor').change(function() {
        cargarIndicador();
    });

    // Variables globales para almacenar los datos del gráfico
    var labels = [];
    var valores = [];
    var ventasAsesorChart;

    // Función para cargar el indicador
    function cargarIndicador() {
        // Obtener los valores seleccionados
        var anio = $('#ventasasesoranio').val();
        var mes = $('#mesasesor').val();

        // Hacer la solicitud AJAX
        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/VentasAsesorformaletas/' + anio + '/' + mes,
            type: 'GET',
            success: function(response) {
                // Actualizar la tabla con los datos recibidos
                actualizarTabla(response);

                // Actualizar el gráfico con los nuevos datos
                actualizarGrafico();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // Función para actualizar la tabla y almacenar los datos para el gráfico
    function actualizarTabla(data) {
        var tbody = $('#ventasAsesorMes tbody');
        tbody.empty();

        // Limpiar los datos existentes del gráfico
        labels = [];
        valores = [];

        // Mapeo de números de mes a nombres de mes
        var meses = {
            1: 'Enero',
            2: 'Febrero',
            3: 'Marzo',
            4: 'Abril',
             5: 'Mayo',
            6: 'Junio',
            7: 'Julio',
            8: 'Agosto',
            9: 'Septiembre',
            10: 'Octubre',
            11: 'Noviembre',
            12: 'Diciembre'
        };

        // Recorrer los datos y agregar filas a la tabla
        for (var i = 0; i < data.length; i++) {
            var row = $('<tr>');
            row.append($('<td>').text(meses[data[i].mes])); // Mostrar nombre del mes
            row.append($('<td>').text(data[i].Nombre_Asesor));
            row.append($('<td>').text(data[i].total_ventas));
            row.append($('<td>').text(formatoMoneda(data[i].total_valor)));

            tbody.append(row);

            // Almacenar los datos para el gráfico
            labels.push(data[i].Nombre_Asesor);
            valores.push(data[i].total_valor);
        }
    }

    // Función para formatear el valor en moneda colombiana
    function formatoMoneda(valor) {
        return parseFloat(valor).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }

    // Función para crear o actualizar el gráfico utilizando Chart.js
    function actualizarGrafico() {
        // Obtener el contexto del lienzo del gráfico
        var ctx = document.getElementById('ventasAsesorChart').getContext('2d');
        var colorPalette = ['#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37', '#9B59B6', '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'];
        // Verificar si ya existe un gráfico, de lo contrario, crear uno nuevo
        if (ventasAsesorChart) {
            // Si ya existe un gráfico, actualizar sus datos
            ventasAsesorChart.data.labels = labels;
            ventasAsesorChart.data.datasets[0].data = valores;
            ventasAsesorChart.update(); // Actualizar el gráfico
        } else {
            // Si no existe un gráfico, crear uno nuevo
            ventasAsesorChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico (puedes cambiarlo según tus necesidades)
                data: {
                    labels: labels, // Etiquetas en el eje X
                    datasets: [{
                        label: 'Ventas por Asesor', // Etiqueta de los datos
                        data: valores, // Valores en el eje Y
                        backgroundColor:colorPalette.slice(0, valores.length), // Colores de fondo de las barras
                        borderColor: colorPalette.slice(0, valores.length), // Color del borde de las barras
                        borderWidth: 1 // Ancho del borde de las barras
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true, // Comenzar en 0 en el eje Y
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(0) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(0) + 'K';
                                    } else if (value > 0) {
                                        return value + 'K';
                                    } else {
                                        return value.toLocaleString('es-CO', {
                                            style: 'currency',
                                            currency: 'COP',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }
                            }
                            
                        }]
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var value = context.dataset.data[context.dataIndex];
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(2).replace(/\.?0+$/, '') + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(2).replace(/\.?0+$/, '') + 'K';
                                    } else {
                                        return value.toLocaleString('es-CO', {
                                            style: 'currency',
                                            currency: 'COP',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    }
});

// //ventas asesores en seguimiento

$(document).ready(function() {
    // Cargar indicador al cargar la página
    cargarIndicador();

    // Detectar cambios en los selects
    $('#ventasasesoranioseguimiento, #mesasesorseguimiento').change(function() {
        cargarIndicador();
    });

    // Función para cargar el indicador
    function cargarIndicador() {
        // Obtener los valores seleccionados
        var anio = $('#ventasasesoranioseguimiento').val();
        var mes = $('#mesasesorseguimiento').val();

        // Hacer la solicitud AJAX
        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/VentasAsesorSeguimientoformaletas/' + anio + '/' + mes,
            type: 'GET',
            success: function(response) {
                // Actualizar la tabla y el gráfico con los datos recibidos
                actualizarTabla(response);
                generarGrafico(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // Función para actualizar la tabla con los datos recibidos
    function actualizarTabla(data) {
        var tbody = $('#ventasAsesorMesSeguimiento tbody');
        tbody.empty();

        // Mapeo de números de mes a nombres de mes
        var meses = {
            1: 'Enero',
            2: 'Febrero',
            3: 'Marzo',
            4: 'Abril',
            5: 'Mayo',
            6: 'Junio',
            7: 'Julio',
            8: 'Agosto',
            9: 'Septiembre',
            10: 'Octubre',
            11: 'Noviembre',
            12: 'Diciembre'
        };

        // Recorrer los datos y agregar filas a la tabla
        for (var i = 0; i < data.length; i++) {
            var row = $('<tr>');
            row.append($('<td>').text(meses[data[i].mes])); // Mostrar nombre del mes
            row.append($('<td>').text(data[i].Nombre_Asesor));
            row.append($('<td>').text(data[i].total_ventas));
            row.append($('<td>').text(formatoMoneda(data[i].total_valor)));

            tbody.append(row);
        }
    }

    // Función para generar el gráfico de barras
    function generarGrafico(data) {
        // Obtener los datos para el gráfico
        var nombresAsesores = [];
        var totalesVentas = [];

        for (var i = 0; i < data.length; i++) {
            nombresAsesores.push(data[i].Nombre_Asesor);
            totalesVentas.push(data[i].total_valor);
        }

        // Crear el gráfico de barras
        var ctx = document.getElementById('ventasAsesorSeguimientoChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: nombresAsesores,
                datasets: [{
                    label: 'Ventas por Asesor',
                    data: totalesVentas,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Color de fondo de las barras
                    borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return (value / 1000000).toFixed(0) + 'M';
                                } else if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + 'K';
                                } else if (value > 0) {
                                    return value + 'K';
                                } else {
                                    return value.toLocaleString('es-CO', {
                                        style: 'currency',
                                        currency: 'COP',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    }]
                }
            }
        });
    }

    // Función para formatear el valor en moneda colombiana
    function formatoMoneda(valor) {
        return parseFloat(valor).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP'
        });
    }
});




// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// //GRAFICO TORTA COTIZACIONES

$(document).ready(function() {
    var chart = null;

    // Cargar ventas_mes inicialmente
    cargarVentasMes();

    // Manejar cambio de opción en el select
    $('#seguimientoano').change(function() {
        cargarVentasMes();
    });

    function cargarVentasMes() {
        var anios = $('#seguimientoano').val();
        var url = 'https://rdpd.sagerp.co:59881/gestioncalidad/public/ventas-mes-seguimientoFor-ajax/' + anios;

        $.ajax({
            url: url,
            success: function(data) {
                // Vaciar tabla y agregar datos de ventas_mes
                $('#ventas-mes-seguimiento').DataTable().destroy(); // Destruye la instancia anterior de DataTables si existe.
                $('#ventas-mes-seguimiento tbody').empty();
                data.forEach(function(venta) {
                    var row = $('<tr>');
                    row.append($('<td>').text(moment(venta.mes + '-01').locale('es').format('MMMM')));

                    var formattedTotal = Number(venta.total).toLocaleString('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    });
                    row.append($('<td>').text(formattedTotal));
                    $('#ventas-mes-seguimiento tbody').append(row);
                });

                // Inicializa la tabla como un DataTable
                $('#ventas-mes-seguimiento').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    "order": [[ 0, "desc" ]]
                });

                // Destruir instancia del gráfico anterior si existe
                if (chart !== null) {
                    chart.destroy();
                }

                // Crear gráfica de ventas mensuales en seguimiento 
                var ctx = document.getElementById('ventas-seguimiento-grafica-torta').getContext('2d');
                var colors = ['#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37', '#9B59B6', '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'];

                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.map(function(venta) {
                            return moment(venta.mes + '-01').format('MMMM');
                        }),
                        datasets: [{
                            label: 'Ocultar',
                            data: data.map(function(venta) {
                                return venta.total;
                            }),
                            backgroundColor: colors.slice(0, data.length),
                            borderColor: '#FF5733',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return value.toLocaleString('es-CO', {
                                        style: 'currency',
                                        currency: 'COP',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    }
                });
            }
        });
    }
});
// ////////////////////////////////////////////////////////////////////////////////////////////

// //VENTAS TORTA

$(document).ready(function() {
    var chart = null;
    var tabla;
    var anioSeleccionado = '';

    dibujarGrafico();

    $('#anio').change(function() {
        dibujarGrafico();
    });

    function dibujarGrafico() {
        var anio = $('#anio').val();

        if (anio !== anioSeleccionado) {
            anioSeleccionado = anio;

            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/ventas-mes-ajaxFor/' + anio,
                success: function(data) {
                    if (chart !== null) {
                        chart.destroy();
                    }

                    var ctx = document.getElementById('ventas-mes-torta').getContext('2d');
                    var colors = ['#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37', '#9B59B6', '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'];

                    chart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.map(function(venta) {
                                return moment(venta.mes + '-01').format('MMMM');
                            }),
                            datasets: [{
                                label: 'Ocultar',
                                data: data.map(function(venta) {
                                    return venta.total;
                                }),
                                backgroundColor: colors.slice(0, data.length),
                                borderColor: '#FFFFFF',
                                borderWidth: 1,
                                datalabels: {
                                    formatter: function(value, context) {
                                        return formatoMoneda(value);
                                    }
                                }
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'end',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                        return formatoMoneda(value);
                                    }
                                }
                            }
                        }
                    });

                    if (tabla) {
                        tabla.destroy();
                    }

                    $('#ventas-mes tbody').empty();

                    data.forEach(function(venta) {
                        var row = $('<tr>');
                        row.append($('<td>').text(moment(venta.mes + '-01').format('MMMM')));
                        var formattedTotal = formatoMoneda(venta.total);
                        row.append($('<td>').text(formattedTotal));
                        $('#ventas-mes tbody').append(row);
                    });

                    tabla = $('#ventas-mes').DataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en AJAX: ' + errorThrown);
                }
            });
        }
    }

    function formatoMoneda(valor) {
        return Number(valor).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }
});


// //metros  cuadrados mes cotizados  en kg
// $(document).ready(function() {
//     var chart = null;

//     // Cargar metros cuadrados por mes inicialmente
//     cargarMetrosCuadradosPorMes();

//     // Manejar cambio de opción en el select
//     $('#anioMetroscuadrados').change(function() {
//         cargarMetrosCuadradosPorMes();
//     });

//     function cargarMetrosCuadradosPorMes() {
//         var anio = $('#anioMetroscuadrados').val();
//         var url = '/MetrosCuadrados/' + anio;

//         $.ajax({
//             url: url,
//             success: function(data) {
//                 // Destruir instancia del gráfico anterior si existe
//                 if (chart !== null) {
//                     chart.destroy();
//                 }

//                 // Crear gráfica de metros cuadrados por mes
//                 var ctx = document.getElementById('GraficoMetrosCuadrados').getContext('2d');

//                 var labels = data.map(function(row) {
//                     var date = new Date(row.mes + '-01');
//                     return date.toLocaleString('default', { month: 'long' });
//                 });

//                 chart = new Chart(ctx, {
//                     type: 'bar',
//                     data: {
//                         labels: labels,
//                         datasets: [{
//                             label: 'Metros cuadrados por mes',
//                             data: data.map(function(row) {
//                                 return row.total_metros_cuadrados;
//                             }),
//                             backgroundColor: colorPalette,
//                             borderColor: 'rgba(75, 192, 192, 1)',
//                             borderWidth: 1
//                         }]
//                     },
//                     options: {
//                         responsive: true,
//                         maintainAspectRatio: true,
//                         scales: {
//                             yAxes: [{
//                                 ticks: {
//                                     beginAtZero: true,
//                                     callback: function(value) {
//                                         if (value >= 1000000) {
//                                             return (value / 1000000).toFixed(0) + 'M';
//                                         } else if (value >= 1000) {
//                                             return (value / 1000).toFixed(0) + 'K';
//                                         } else if (value > 0) {
//                                             return value + 'K';
//                                         } else {
//                                             return value.toLocaleString('es-CO', {
//                                                 style: 'currency',
//                                                 currency: 'COP',
//                                                 minimumFractionDigits: 0,
//                                                 maximumFractionDigits: 2
//                                             });
//                                         }
//                                     }
//                                 }
//                             }]
//                         }
//                     }
//                 });

//                 // Actualizar la tabla de metros cuadrados por mes
//                 var tabla = $('#tablametroscuadrados tbody');
//                 tabla.empty();

//                 for (var i = 0; i < data.length; i++) {
//                     var row = $('<tr>');
//                     row.append($('<td>').text(labels[i]));
//                     row.append($('<td>').text(data[i].cantidad_registros));
//                     row.append($('<td>').text(formatoMetrosCuadrados(data[i].total_metros_cuadrados)));
//                     tabla.append(row);
//                 }
//             }
//         });
//     }
// });

// // Función para formatear metros cuadrados
// function formatoMetrosCuadrados(valor) {
//     return Number(valor).toLocaleString('es-CO', {
//         minimumFractionDigits: 0,
//         maximumFractionDigits: 2
//     });
// }


// //porcentaje de exito 
$(document).ready(function() {
    // Obtener el elemento select para el año
    var selectAnio = $('#porcentajeExito');

    // Cargar el gráfico y la tabla inicialmente
    cargarPorcentajeExitoVentas(selectAnio.val());

    // Manejar cambio de opción en el select
    selectAnio.change(function() {
        cargarPorcentajeExitoVentas($(this).val());
    });

    function obtenerNombreMes(numeroMes) {
        var meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        return meses[numeroMes - 1];
    }


    function cargarPorcentajeExitoVentas(anio) {
        var url = 'https://rdpd.sagerp.co:59881/gestioncalidad/public/Porcentaje-Exito-cotizaciones-formaletas/' + anio;
        $.ajax({
            url: url,
            success: function(data) {
                // Actualizar el gráfico de porcentaje de éxito
                actualizarGraficoPorcentajeExito(data);
                // Actualizar la tabla de porcentaje de éxito
                actualizarTablaPorcentajeExito(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function actualizarGraficoPorcentajeExito(data) {
        // Obtener los meses y porcentajes de éxito
        var meses = data.map(function(item) {
            return obtenerNombreMes(item.mes);
        });
        var porcentajes = data.map(function(item) {
            return item.porcentaje;
        });
    
        // Crear el gráfico de porcentaje de éxito
        var ctx = document.getElementById('graficoPorcentajeExito').getContext('2d');
    
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Porcentaje de Éxito',
                    data: porcentajes,
                    backgroundColor: [
                        '#FF5733', '#36A2EB', '#FFCE56', '#00CC99', '#FF5733', '#6F4E37',
                        '#9B59B6',
                        '#7D6608', '#C0392B', '#27AE60', '#2980B9', '#F39C12'
                    ],
                    borderColor: '#FF5733',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var value = context.dataset.data[context.dataIndex];
                                return value.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    
    function actualizarTablaPorcentajeExito(data) {
        var tabla = $('#tablaPorcentajeExito tbody');
        tabla.empty();
    
        for (var i = 0; i < data.length; i++) {
            var row = $('<tr>');
            row.append($('<td>').text(obtenerNombreMes(data[i].mes)));
            var porcentajeRedondeado = parseFloat(data[i].porcentaje.toFixed(1));
            row.append($('<td>').text(porcentajeRedondeado + '%'));
            tabla.append(row);
        }
    }
});




