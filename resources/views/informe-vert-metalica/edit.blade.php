@extends('layouts.dashboard')

@section('template_title')
    Update Informe Vert Metalica
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Datos Informe Vert Metalica</span>
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
                                    action="{{ route('informe-vert-metalica.update', $informeVertMetalica->id) }}"
                                    role="form" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf

                                    @include('informe-vert-metalica.form')
                                </form>
                            </div>
                            <div class="tab-pane fade" id="juntas" role="tabpanel" aria-labelledby="juntas-tab">
                                <a class="btn btn-sm btn-primary" style="margin: 15px" data-toggle="modal"
                                    data-target="#modal-juntas" onclick="clearForm()"><i class="fa fa-fw fa-plus"></i>Agregar</a>

                                <input type="hidden" id="id_juntas">

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tabla_juntas">
                                        <thead class="thead">
                                            <tr>
                                                <th>Id</th>
                                                <th>Id_Columna</th>
                                                <th>Teorica</th>
                                                <th>Real</th>
                                                <th>Desviacion</th>
                                                <th>Altura_Columna</th>
                                                <th>Tolerancia</th>
                                                <th>Norte_1</th>
                                                <th>Norte_2</th>
                                                <th>Sur_1</th>
                                                <th>Sur_2</th>
                                                <th>Oriente_1</th>
                                                <th>Oriente_2</th>
                                                <th>Occidente_1</th>
                                                <th>Occidente_2</th>
                                                <th>Resultado_inspeccion</th>
                                                <th>Accion_Seleccionar</th>
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


<!-- Modal -->
<div class="modal fade" id="modal-juntas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informacion de juntas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display: none">
                    <input type="hidden" id="id">
                    <input type="hidden" name="id_informe" id="id_informe"
                    value="{{ $informeVertMetalica->id }}">
                    {{ $juntasInformeVertMetalica = new App\Models\JuntasInformeVertMetalica() }}
                </div>
                @include('juntas-informe-vert-metalica.form')
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('js/cruds/juntas_informe_ver_metalica.js') }}"></script>
@endsection