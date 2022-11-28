@extends('layouts.dashboard')

@section('template_title')
    Update Informe Ultrasonido
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Datos Informe Ultrasonido</span>
                    </div>
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab"
                                    aria-controls="general" aria-selected="true">Informacion General</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="juntas-tab" data-toggle="tab" href="#juntas" role="tab"
                                    aria-controls="juntas" aria-selected="false">Juntas</a>
                            </li>
                        </ul>


                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="general" role="tabpanel"
                                aria-labelledby="general-tab">

                                <form method="POST"
                                    action="{{ route('informe-ultrasonido.update', $informeUltrasonido->id) }}"
                                    role="form" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf

                                    @include('informe-ultrasonido.form')

                                </form>
                            </div>
                            <div class="tab-pane fade" id="juntas" role="tabpanel" aria-labelledby="juntas-tab">
                                <a class="btn btn-sm btn-primary" id="btn-agregar-juntas" style="margin: 15px" data-toggle="modal"
                                    data-target="#modal-juntas" ><i
                                        class="fa fa-fw fa-plus"></i>Agregar</a>


                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tabla_juntas">
                                        <thead class="thead">
                                            <tr>
                                                <th>Id</th>
                                                <th>Fecha</th>
                                                <th>Identificacion_Elemento</th>
                                                <th>Junta</th>
                                                <th>Datos</th>
                                                <th>Seleccione_Opcion</th>
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
        </div>
    </section>
@endsection



<!-- Modal  Juntas Ultrasonido-->
<div class="modal fade" id="modal-juntas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display: none">
                    <input type="hidden" id="id-junta">
                    <input type="hidden" name="id_informe" id="id_informe" value="{{ $informeUltrasonido->id }}">
                    {{ $juntasInformeUltrasonido = new App\Models\JuntasInformeUltrasonido() }}
                </div>
                @include('juntas-informe-ultrasonido.form')
            </div>
        </div>
    </div>
</div>


<!-- Modal Datos Juntas Ultrasonido-->
<div class="modal fade" id="modal-datos-juntas" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    id="btnAddEditDatosJuntas">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display: none">
                    {{ $datosJuntasInformeUltrasonido = new App\Models\DatosJuntasInformeUltrasonido() }}
                </div>

                <div id="tabla-datos-juntas">
                    {{-- funcion del archivo datos_juntas_informe_ultrasonido.js --}}
                    <a class="btn btn-sm btn-primary" style="margin: 15px" id="btn-agregar-dato-junta" onclick="mostrarFormularioDetalleJuntas()"><i
                            class="fa fa-fw fa-plus"></i>Agregar</a>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabla_datos_juntas">
                            <thead class="thead">
                                <tr>
                                    <th>Id</th>
                                    <th>Ubicacion_Junta</th>
                                    <th>indicacion_Numero</th>
                                    <th>Desde_Cara</th>
                                    <th>Pierna</th>
                                    <th>Nivel_Indicacion</th>
                                    <th>Nivel_Referencia</th>
                                    <th>Factor_Atenuacion</th>
                                    <th>Valoracion_Indicacion</th>
                                    <th>Longitud_Defecto</th>
                                    <th>Distancia_Angular</th>
                                    <th>Profundidad_Desde</th>
                                    <th>Evaluacion_Discontinuidad_1</th>
                                    <th>Evaluacion_Discontinuidad_2</th>
                                    <th>Evaluacion_Discontinuidad_3</th>
                                    <th>Distancia_Desde_x</th>
                                    <th>Distancia_Desde_y</th>
                                    <th>Estampe_Soldador</th>
                                    <th>Observaciones</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="datos-junta-formulario" style="display: none">
                    <input type="hidden" name="id-junta" id="id-junta">
                    <input type="hidden" name="id-dato-junta" id="id-dato-junta">
                    @include('datos-juntas-informe-ultrasonido.form')
                </div>

            </div>
        </div>
    </div>
</div>


