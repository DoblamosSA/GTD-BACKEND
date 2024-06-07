@extends('layouts.dashboard')

@section('template_title')
Indicadores Costos de no calidad
@endsection

@section('content')
<br>

<head>
    <!-- Incluir hoja de estilos y librería de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha384-VzLXTJGPSyTLX6d96AxgkKvE/LRb7ECGyTxuwtpjHnVWVZs2gp5RDjeM/tgBnVdM" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha384-RFZC58YeKApoNsIbBxf4z6JJXmh+geBSgkCQXFyh+4tiFSJmJBt+2FbjxW7Ar16M" crossorigin=""></script>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <h5 style="text-align:center;background-color:#3d444412"> Cotizaciones en seguimiento</h5>
                        <select name="seguimientosano" id="seguimientoano" class="form-control">
                            @for ($i = date('Y'); $i >= 2015; $i--)
                            <option value="{{ $i }}" @if ($seguimientosano==$i) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>
                        <canvas id="ventas-seguimiento-grafica"></canvas>
                        <table class="table table-bordered table-striped" id="ventas-mes-seguimiento">
                            <thead class="table-info">
                                <tr>
                                    <th>Mes</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 style="text-align:center;background-color:#3d444412"> Ventas Mes</h5>
                        <select name="$anios" id="anio" class="form-control">
                            @for ($i = date('Y'); $i >= 2015; $i--)
                            <option value="{{ $i }}" @if ($anios==$i) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>
                        <canvas id="ventas-mes-chart" width="400" height="200"></canvas>
                        <table class="table table-bordered table-striped" id="ventas-mes">
                            <thead class="table-info">
                                <tr>
                                    <th>Mes</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
			 <div class="card">
                <div class="row">
                    <div class="col-md-6">
                    <div style="background-color: #3d444412; text-align:center">
                            <h5>Cotizaciones en seguimiento</h5>
                        </div>
                        <canvas id="ventas-seguimiento-grafica-torta"></canvas>
                    </div>
                    <div class="col-md-6">
                    <div style="background-color: #3d444412; text-align:center">
                            <h5>Ventas Mes</h5>
                        </div>
                        <canvas id="ventas-mes-torta"></canvas>
                    </div>

                </div>

            </div>



            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Contenido del primer gráfico -->
                        <div style="background-color: #3d444412; text-align:center">
                            <h5>Ventas por tipología</h5>
                        </div>
                        <div style="overflow:hidden">
                            <select name="aniotipologia" id="select-ano" class="form-control"
                                style="width:50%;float:left;">
                                @for ($i = date('Y'); $i >= 2015; $i--)
                                <option value="{{ $i }}" @if ($aniotipologia==$i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                            <select id="select-tipologia" class="form-control" placeholder="Tipologia"
                                style="width:50%;float:left;">
                                <option class="form-control" value="Fachadas 2D">Fachadas 2D</option>
                                <option class="form-control" value="Fachadas 3D">Fachadas 3D</option>
                                <option class="form-control" value="Cerramientos">Cerramientos</option>
                                <option class="form-control" value="Puertas">Puertas</option>
                                <option class="form-control" value="Lamina Perforada">Lamina Perforada</option>
                                <option class="form-control" value="Paneles">Paneles</option>
                                <option class="form-control" value="Cielos">Cielos</option>
                                <option class="form-control" value="Louvers">Louvers</option>
                                <option class="form-control" value="Corta Soles">Corta Soles</option>
                                <option class="form-control" value="Avisos">Avisos</option>
                                <option class="form-control" value="Pasamanos">Pasamanos</option>
                                <option class="form-control" value="Otros">Otros</option>
                            </select>
                            <br>

                            <div>
                                <canvas id="vntaTipologia"></canvas>
                            </div>
                            <br>
                            <table class="table table-bordered table-striped" id="cotizaciones-tipologia">
                                <thead class="table-info">
                                    <tr>
                                        <th>Mes</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <!-- Contenido del segundo gráfico -->
                        <div style="overflow:hidden">
                            <div style="background-color: #3d444412; text-align:center">
                                <h5>Cotizaciones por tipología seguimiento</h5>
                            </div>
                            <select name="aniotipologiaseguimiento" id="anioseg" class="form-control"
                                style="width:50%;float:left;">
                                @for ($i = date('Y'); $i >= 2015; $i--)
                                <option value="{{ $i }}" @if ($aniotipologiaseguimiento==$i) selected @endif>{{ $i }}
                                </option>
                                @endfor
                            </select>
                            <select id="select-cotizacionseguimiento" class="form-control" placeholder="Tipologia"
                                style="width:50%;float:left;">
                                <option class="form-control" value="Fachadas 2D">Fachadas 2D</option>
                                <option class="form-control" value="Fachadas 3D">Fachadas 3D</option>

                                <option class="form-control" value="Cerramientos">Cerramientos</option>
                                <option class="form-control" value="Puertas">Puertas</option>
                                <option class="form-control" value="Lamina Perforada">Lamina Perforada</option>
                                <option class="form-control" value="Paneles">Paneles</option>
                                <option class="form-control" value="Cielos">Cielos</option>
                                <option class="form-control" value="Louvers">Louvers</option>
                                <option class="form-control" value="Corta Soles">Corta Soles</option>
                                <option class="form-control" value="Avisos">Avisos</option>
                                <option class="form-control" value="Pasamanos">Pasamanos</option>
                                <option class="form-control" value="Otros">Otros</option>
                            </select>
                            <br>
                            <canvas id="GraficoVentasSeguimientoTipologia"></canvas>
                            <br>
                            <table class="table table-bordered table-striped" id="VentasSeguimientotipo">
                                <thead class="table-info">
                                    <tr>
                                        <th>Pais</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>

    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <!-- Contenido del tercer gráfico -->
                <div style=" background-color: #3d444412;text-align:center ">
                    <h5>Tendencia de ventas por tipologia</h5>
                </div>

                <select name="VentasGeneralesTipologiasanio" id="VentasGeneralesTipologiasanio" class="form-control">
                    @for ($i = date('Y'); $i >= 2015; $i--)
                    <option value="{{ $i }}" @if ($VentasGeneralesTipologiasanio==$i) selected @endif>{{ $i }}
                    </option>
                    @endfor

                </select>
                <br>
                <div>
                    <canvas id="VentasGeneralesTipologias" width="100" height="29"></canvas>
                </div>
                <br>
                <table class="table table-bordered table-striped" id="tablaventastipologiageneral">
                    <thead class="table-info">
                        <tr>
                            <th>Tipología</th>
                            <th>Mes</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div style=" background-color: #3d444412;text-align:center ">
                    <h5>Tendencia de cotizaciones por tipología</h5>
                </div>

                <select class="form-control" name="CotizacionesGeneralesTipologiasanio"
                    id="CotizacionesGeneralesTipologiasanio">
                    @for ($i = date('Y'); $i >= 2015; $i--)
                    <option value="{{ $i }}" @if ($CotizacionesGeneralesTipologiasanio==$i) selected @endif>{{ $i }}
                    </option>
                    @endfor
                </select>

                <br>
                <div>
                    <canvas id="CotizacionesGeneralesTipologias" width="100" height="29"></canvas>
                </div>
                <br>
                <table class="table table-bordered table-striped" id="cotizacionestablaventastipologiageneral">
                    <thead class="table-info">
                        <tr>
                            <th>Tipología</th>
                            <th>Mes</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row">

            <div class="col-md-12">
                <div style=" background-color: #3d444412;text-align:center ">
                    <h5>Origen de las cotizaciones</h5>
                </div>
                <select name="CotizacionesOrigenanio" id="CotizacionesOrigenanio" class="form-control">
                    @for ($i = date('Y'); $i >= 2015; $i--)
                    <option value="{{ $i }}" @if ($CotizacionesOrigenanio==$i) selected @endif>{{ $i }}
                    </option>
                    @endfor
                </select>
                <br>
                <div>
                    <canvas id="CotizacionesOrigen" width="100" height="29"></canvas>
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
        </div>
    </div>



    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <div style=" background-color: #3d444412;text-align:center ">
                    <h5>Ventas Internacionales</h5>
                </div>

                <select name="ventaspais" id="ventaspais" class="form-control">
                    @for ($i = date('Y'); $i >= 2015; $i--)
                    <option value="{{ $i }}" @if ($ventaspais==$i) selected @endif>{{ $i }}</option>
                    @endfor

                </select>
                <br>
                <div id="map" style="height: 500px; width: 100%; "></div>
                <br>
                <div style="width: 100%; max-width: 800px; margin: 0 auto;">
                    <canvas id="bar-chart" width="800" height="400"></canvas>
                </div>
                <table class="table table-bordered table-striped" id="ventas-mes-pais">
                    <thead class="table-info">
                        <tr>
                            <th>Pais</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>




            </div>


            <div class="col-md-6">
                <div style="background-color: #3d444412; text-align:center">
                    <h5>Cotizaciones Internacionales en seguimiento</h5>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <select name="ventaspaisseguimiento" class="form-control" id="ventaspaisseguimiento">
                            @for ($i = date('Y'); $i >= 2015; $i--)
                            <option value="{{ $i }}" @if ($ventaspaisseguimiento==$i) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="messeguimiento" class="form-control" id="messeguimiento">
                            @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}" @if ($messeguimiento==$m) selected
                                @endif>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endfor
                        </select>
                    </div>
                </div>


                <br>
                <div id="cotizacionesSeguimiento" style="height: 500px; width: 100%;"></div>
                <br>
                <div>
                    <canvas id="graficoBarrasSeguimiento" width="400" height="400"></canvas>
                </div>
                <table class="table table-bordered table-striped" id="ventas-mes-pais-seguimiento">
                    <thead class="table-info">
                        <tr>
                            <th>Mes</th>
                            <th>Pais</th>
                            <th>Numero cotizaciónes</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div>



                </div>

            </div>
        </div>

        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div style="background-color: #3d444412; text-align:center">
                        <h5>Ventas Asesores</h5>
                    </div>
                    <select name="ventasasesoranio" class="form-control" id="ventasasesoranio">

                        @for ($i = date('Y'); $i >= 2015; $i--)
                        <option value="{{ $i }}" @if ($ventasasesoranio==$i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="mesasesor" class="form-control" id="mesasesor">
                        @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}" @if ($messeguimiento==$m) selected
                            @endif>
                            {{ strftime('%B', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                            @endfor
                    </select>


                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="ventasAsesorMes">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Mes</th>
                                    <th>Asesor</th>
                                    <th>Cantidad de ventas</th>
                                    <th>Venta</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <canvas id="ventasAsesorChart"></canvas>

                    <br>


                </div>

                <div class="col-md-6">
                    <div style="background-color: #3d444412; text-align:center">
                        <h5>Cotizaciones Asesores en seguimiento</h5>
                    </div>
                    <select name="ventasasesoranioseguimiento" class="form-control" id="ventasasesoranioseguimiento">

                        @for ($i = date('Y'); $i >= 2015; $i--)
                        <option value="{{ $i }}" @if ($ventasasesoranioseguimiento==$i) selected @endif>{{ $i }}
                        </option>
                        @endfor
                    </select>
                    <select name="mesasesorseguimiento" class="form-control" id="mesasesorseguimiento">
                        @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}" @if ($mesasesorseguimiento==$m) selected
                            @endif>
                            {{ strftime('%B', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                            @endfor
                    </select>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="ventasAsesorMesSeguimiento">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Mes</th>
                                    <th>Asesor</th>
                                    <th>Cantidad de cotizaciones</th>
                                    <th>Venta</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div>
                            <canvas id="ventasAsesorSeguimientoChart"></canvas>
                        </div>

                    </div>
                    <br>
                    

                </div>
<div class="col-md-6">
                        <h5 style="text-align:center;background-color:#3d444412"> Costos de no calidad</h5>
                        <select name="aniocostonocalidad" id="aniocostocalidad" class="form-control"
                            onchange="obtenerCostosCalidad(this.value)">
                            @for ($i = date('Y'); $i >= 2015; $i--)
                            <option value="{{ $i }}" @if ($aniocostonocalidad==$i) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>


                        <canvas id="GraficoCostosCalidad"></canvas>
                        <table class="table table-bordered table-striped" id="Costoscalidad">

                            <thead class="table-info">
                                <tr>
                                    <th>Mes</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
<div class="col-md-6">
                    <h5 style="text-align:center;background-color:#3d444412">Indicador Metros cuadrados Mes</h5>
                    <select name="aniometroscuadrados" id="anioMetroscuadrados" class="form-control">
                        @for ($i = date('Y'); $i >= 2015; $i--)
                        <option value="{{ $i }}" @if ($anioMetroscuadrados==$i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>

                    <canvas id="GraficoMetrosCuadrados"></canvas>

                    <table class="table table-bordered table-striped" id="tablametroscuadrados">
                        <thead class="table-info">
                            <tr>
                                <th>Mes</th>
                                <th>Cantidad cotizaciones</th>
                                <th>Suma M2 mes</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
	
<div class="card">
<h5 style="text-align:center;background-color:#3d444412">Porcentaje de éxito</h5>
    <div class="row">
        
        <div class="col-md-6">
            
            <select name="porcentajeExito" id="porcentajeExito" class="form-control">
                @for ($i = date('Y'); $i >= 2015; $i--)
                <option value="{{ $i }}" @if ($porcentajeExito==$i) selected @endif>{{ $i }}</option>
                @endfor
            </select>
            <br>
            <canvas id="graficoPorcentajeExito"></canvas>
        </div>
        <div class="col-md-6">
            <table id="tablaPorcentajeExito" class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Mes</th>
                        <th>Porcentaje de Éxito</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    </div>
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
<script src="{{ asset('js/IndicadoresVortex/IndicadoresVortex.js') }}"></script>


@endsection