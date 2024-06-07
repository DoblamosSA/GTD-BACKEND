@extends('layouts.dashboard')

@section('content')
<br> <br><br> <br>
<div class="card shadow">
    <div class="card-body">

        <div class="row">
            <div class="col-md-6 mb-4">
                <canvas id="usersChart" class="chart"></canvas>
            </div>
            <div class="col-md-6 mb-4">
                <canvas id="salesChart" class="chart"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="expensesChart" class="chart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="productsChart" class="chart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Datos de ejemplo para los gr�ficos
    var usersData = [{{ $usersCount }}];
    var salesData = [/* Tus datos de ventas */ ];
    var expensesData = [/* Tus datos de gastos */ ];
    var productsData = [/* Tus datos de productos */ ];

    // Configuraci�n de gr�ficos
    var chartsConfig = {
        usersChart: {
            label: 'Usuarios',
            data: usersData,
            backgroundColor: [
                'rgba(255, 165, 0, 0.7)', // Naranja
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)'
            ],
            borderColor: [
                'rgba(255, 165, 0, 1)', // Naranja
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
        },
        salesChart: {
            label: 'cotizaciones',
            data: salesData,
            backgroundColor: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
        },
        expensesChart: {
            label: 'Solicitudes creditos',
            data: expensesData,
            backgroundColor: 'rgba(255, 206, 86, 0.7)',
            borderColor: 'rgba(255, 206, 86, 1)',
        },
        productsChart: {
            label: 'Uso aplicativo',
            data: productsData,
            backgroundColor: 'rgba(75, 192, 192, 0.7)',
            borderColor: 'rgba(75, 192, 192, 1)',
        },
    };

    // Crear gr�ficos
    Object.keys(chartsConfig).forEach(function (chartId) {
        var ctx = document.getElementById(chartId).getContext('2d');
        var chartConfig = chartsConfig[chartId];

        new Chart(ctx, {
            type: chartId === 'usersChart' ? 'doughnut' : 'bar',
            data: {
                labels: [chartConfig.label],
                datasets: [{
                    label: chartConfig.label,
                    data: chartConfig.data,
                    backgroundColor: chartConfig.backgroundColor,
                    borderColor: chartConfig.borderColor,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: 'black',
                        fontSize: 14
                    }
                },
                elements: {
                    point: {
                        radius: 0
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Total ' + chartConfig.label.toLowerCase() + ' registrados',
                        fontSize: 16
                    }
                }
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    .chart {
        max-width: 100%;
        height: 200px; /* Ajusta la altura seg�n tu preferencia */
    }

    .card {
        border: none;
    }

    .card-title {
        color: #3498db;
    }
</style>
@endsection
