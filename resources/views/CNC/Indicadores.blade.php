@extends('layouts.dashboard')

@section('template_title')
Indicadores Costos de no calidad
@endsection



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="row">
                    <div class="col-md-6" style="margin-left: -2%; padding: 60px;">
                    <canvas id="grafico"></canvas></canvas>
                    </div>
                    <div class="col-md-6" style="margin-left: -3%; padding: 60px;">
                    <canvas id="CostosPendientes"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin-left: 3%; padding: 60px;">
                        <form action="{{route('Costo-No-Calidad.IndicadoresC')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicial:</label>
                                <input type="date" name="fecha_inicio" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Final:</label>
                                <input type="date" name="fecha_fin" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Generar Indicador</button>
                        </form>
                    </div>
                    <div class="col-md-6" style="margin-left: -3%; padding: 60px;">
                       
                        <canvas id="CostosPendientes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
var ctx = document.getElementById('grafico').getContext('2d');
var datos = @json($datos);
var cantidadCNC = @json($cantidadCNC);
var costosPendientes = @json($costosPendientes);

var etiquetas = [];
var valores = [];
var cantidadRegistros = [];
var cantidadcostospendientes = [];


datos.forEach(function(dato) {
    etiquetas.push(dato.AreaResponsableCNC);
    valores.push(dato.SaldoFinalCNC);
});
cantidadCNC.forEach(function(dato) {
    cantidadRegistros.push(dato.cantidad);
});
costosPendientes.forEach(function(dato) {
    if (dato.EstadoCNC === "No Costeado") {
       
        cantidadcostospendientes.push(dato.cantidad);

    }
});

var grafico = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: etiquetas,
        datasets: [{
                label: 'SaldoFinalCNC',
                data: valores,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(254, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },
            {
                label: 'Cantidad de costos',
                data: cantidadRegistros,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
            },

            {
                label: 'Cantidad de costeos pendientes',
                data: console.log(cantidadcostospendientes),
                backgroundColor: [
                    'rgba(84, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {

                    beginAtZero: false
                }
            }]
        }
    }
});
</script>

<script>
  var ctx = document.getElementById('CostosPendientes').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: [
              @foreach($costosPendientes as $costoPendiente)
                  '{{ $costoPendiente->AreaResponsableCNC }}',
              @endforeach
          ],
          datasets: [{
              label: 'No Costeados por Area',
              data: [
                  @foreach($costosPendientes as $costoPendiente)
                      {{ $costoPendiente->count }},
                  @endforeach
              ],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
</script>




@endsection