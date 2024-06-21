@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">COSTOS DE NO CALIDAD</a>

                    </div>
                </nav>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <!-- <a class="btn btn btn-primary" href="{{route('Coso-No-Calidad.create')}}"><i></i>Generar CNC
                        </a>
                        <a href="{{route('Costo-No-Calidad.export')}}" class="btn btn btn-success"><i class="fas fa-file-export"></i> Exportar Excel
                        </a>
                        <a href="{{route('Costo-No-Calidad.Indicadores')}}" class="btn btn-warning"><i></i> Indicadores
                        </a>

                        </a> -->


                        <ul class="nav nav-tabs">

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Costo-No-Calidad.index')}}">CNC SIN COSTEAR</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('CNC-COSTEADOS')}}">CNC COSTEADOS</a>
                            </li>
                            @if(auth()->user()->can('Registrar_costonocalidad'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Coso-No-Calidad.create')}}">REGISTRO CNC</a>
                            </li>
                            @endif
                            @if(auth()->user()->can('Export_Costos_No_Calidad'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Costo-No-Calidad.Indicadores')}}">INDICADORES</a>
                            </li>
                            @endif
                            @if(auth()->user()->can('Indicador_Costo_no_Calidad'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Costo-No-Calidad.export')}}">EXPORTAR INFORME</a>
                            </li>
                            @endif
                        </ul>
                    </div>


                </div>

                <br>

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <div class="col">

                    <form id="searchForm" action="{{ route('Costo-No-Calidad.index') }}" method="GET">
                        <div class="btn-group">
                            <div class="col-md-6 ">
                                <select class="form-control" name="QuienCostea">
                                    <option class="form-control" value="" selected disabled>Quien Costea</option>
                                    <option value="Andrea González">Andrea González</option>
                                    <option value="Fredy Quintero">Fredy Quintero</option>
                                    <option value="Daniel Builes">Daniel Builes</option>
                                    <option value="Elmer Uribe">Elmer Uribe</option>
                                    <option value="Camila Villada">Camila Villada</option>
                                    <option value="Santiago Agudelo">Santiago Agudelo</option>
                                    <option value="Elymar Gamboa">Elymar Gamboa</option>
                                    <option value="Elias Ciro">Elias Ciro</option>
                                    <option value="Richard Ruiz">Richard Ruiz</option>
                                    <option value="Fredy Castro">Fredy Castro</option>
                                    <option value="Adriana Cano">Adriana Cano</option>
                                    <option value="Sonia Olaya Lopez">Sonia Olaya Lopez</option>
                                    <option value="Elmer Uribe ">Elmer Uribe</option>


                                </select>

                            </div>
                            <input type="date" name="start_date" class="form-control">
                            <input type="date" name="end_date" class="form-control">
                            <button type="submit" class="btn btn btn-primary">Buscar</button>

                        </div>


                    </form>


                </div>

                <div id="indicador" class="d-none text-center">
                    <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-2"></i>
                    <p class="mb-0">Cargando...</p>
                </div>
                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead class="table-dark">
                        <tr>
                            <th style="font-size: 12px;">Codigo</th>
                            <th style="font-size: 12px;">Fecha CNC</th>
                            <th style="font-size: 12px;">Descripción</th>
                            <th style="font-size: 12px;">C.C/OP</th>
                            <th style="font-size: 12px;">Causa Raíz</th>
                            <th style="font-size: 12px;">Area Responsable CNC</th>
                            <th style="font-size: 12px;">Estado</th>
                            <th style="font-size: 12px;">Subproceso</th>
                            <th style="font-size: 12px;">Responsable costo</th>
                            <th style="font-size: 12px;">Costo CNC</th>
                            <th style="font-size: 12px;">Valor Recuperado</th>
                            <th style="font-size: 12px;">Costo Final - recuperado</th>

                            <th style="font-size: 12px;">Costea</th>
                            <th style="font-size: 12px;">Analista</th>
                            <th style="font-size: 12px;">Conf-asistencia</th>
                            <th style="font-size: 12px;">Acciones</th>

                        </tr>
                    </thead>
                    
                    <tbody id="tableBody">
                        @foreach($costonocalidad as $costonocalidad)
                        <tr>

                            <td style="font-size: 12px;">{{$costonocalidad->id}}</td>
                            <td style="font-size: 12px;">{{$costonocalidad->FechaCNC}}</td>
                            <td style="font-size: 12px;">{{$costonocalidad->Descripcion}}</td>
                            <td style="font-size: 12px;">{{$costonocalidad->Ccop}}</td>
                            <td style="font-size: 12px;">{{$costonocalidad->causa_raiz}}</td>
                            <td style="font-size: 12px;">{{$costonocalidad->AreaResponsableCNC}}</td>
                            <td style="font-size: 12px; background-color: @if($costonocalidad->EstadoCNC == 'No Costeado') #934E4B @elseif($costonocalidad->EstadoCNC == 'Costeado') #B3F295 @elseif($costonocalidad->EstadoCNC == 'En proceso') #FABFBF @endif; color: white;">
                                <b>
                                    {{$costonocalidad->EstadoCNC}}
                                </b>
                            </td>



                            <td style="font-size: 12px;">{{$costonocalidad->SubprocesoCNC}}</td>
                            <td style="font-size: 12px;">{{$costonocalidad->empleado->CardName}}</td>
                            <td style="font-size: 12px;">${{number_format($costonocalidad->CostoCNC)}}</td>
                            <td style="font-size: 12px;">${{number_format($costonocalidad->SaldoRecuperado)}}</td>
                            <td style="font-size: 12px;">${{number_format($costonocalidad->SaldoFinalCNC)}}</td>


                            <td style="font-size: 12px;">{{$costonocalidad->QuienCostea}}</td>
                            <td style="font-size: 12px;">
                                {{$costonocalidad->analista->CardCode}}
                            </td>
                            <td style="font-size: 12px;">
                                {{$costonocalidad->confirmacion_asistencia}}
                            </td>
                            <td style="font-size: 12px;">
                                <form action="{{route('Costo-No-Calidad.destroy',$costonocalidad->id)}}" method="POST" class="formulario-eliminar">

                                    @csrf
                                    @method('PUT')



                                    <a class="btn btn-sm btn-primary" href="{{route('Costo-No-Calidad.Informecnc',$costonocalidad->id)}}" target="_blank"><i class="fas fa-file-pdf"></i>
                                    </a>

                                    @if ($costonocalidad->EstadoCNC == 'Costeado')
                                    @if (Auth::user()->hasRole('Manager'))
                                    <a class="btn btn-sm btn-success" href="{{route('Costo-No-Calidad.edit',$costonocalidad->id)}}"><i class="fa fa-fw fa-edit"></i></a>
                                    @else
                                    <a class="btn btn-sm btn-success" href="#" title="Este costo ya se encuentra cerrado y solo un administrador puede editarlo" disabled><i class="fa fa-fw fa-edit"></i></a>
                                    @endif
                                    @else
                                    <a class="btn btn-sm btn-success" href="{{route('Costo-No-Calidad.edit',$costonocalidad->id)}}"><i class="fa fa-fw fa-edit"></i></a>
                                    @endif
                                    <a class="btn btn-sm btn-dark formulario-duplicarcnc" href="{{route('Costo-No-Calidad.duplicate',$costonocalidad->id)}}" title="Duplicar costo de no calidad" class="formulario-duplicarcnc"><i class="fa fa-fw fa-clone"></i></a>


                                    <a class="btn btn-sm btn-outline-secondary formulario-duplicarcnc" href="{{route('CalculadorCNC.index',$costonocalidad->id)}}" title="Costear costo de no calidad">
                                        <i class="fas fa-calculator"></i>
                                    </a>


                                 

                                    <button type="submit" class="btn btn-danger btn-sm "><i class="fa fa-fw fa-trash"></i></button>
                                  

                                </form>

                            </td>


                        </tr>

                        @endforeach


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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- CSS only -->
@if (session('eliminar') == 'ok')
<script>
    swal.fire(
        'Eliminado!',
        'Costo de no calidad eliminado con éxito!',
        'success'
    )
</script>
@endif


<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();

        swal.fire({
            title: 'Estas seguro que deseas eliminar el Costo de no calidad?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '3085d6',
            CancelButtonColor: '#d33',
            CancelButtonText: 'yes, delete it!'

        }).then((result) => {
            if (result.value) {
                this.submit();
            }

        })
    });
</script>
@if (session('duplicar') == 'ok')
<script>
    let duplicateId = {
        {
            session('duplicateId')
        }
    };
    swal.fire(
        'Costo Duplicado!',
        'Costo duplicado correctamente con codigo: ' + duplicateId,
        'success'
    )
</script>
@endif
<script>
    $('.formulario-duplicarcnc').submit(function(e) {
        e.preventDefault();

        swal.fire({
            title: 'Estás seguro que deseas duplicar este costo?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, cancelar'

        }).then((result) => {
            if (result.value) {
                this.submit();
            }
        })
    });
</script>

<style>
    .indicador {
        background-color: white;
    }
</style>
@endsection