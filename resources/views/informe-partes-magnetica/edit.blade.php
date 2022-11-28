@extends('layouts.dashboard')



@section('content')
    <section class="content container-fluid">
        <br><br>
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Datos Informe Partes Magneticas</span>
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
                                    action="{{ route('informe-partes-magneticas.update', $informePartesMagnetica->id) }}"
                                    role="form" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    <input type="hidden" name="digitar"  value="{{ $informePartesMagnetica->id }}">
                                    @include('informe-partes-magnetica.form')
                                </form>
                            </div>
                            <div class="tab-pane fade" id="juntas" role="tabpanel" aria-labelledby="juntas-tab">
                             
                                    <a class="btn btn-sm btn-primary" style="margin: 15px" data-toggle="modal"
                                        data-target="#modal-juntas"><i class="fa fa-fw fa-plus"
                                            onclick="clearForm()"></i>Agregar</a>
                   
                                <table class="table table-striped table-hover" id="tabla_juntas">
                                    <thead class="thead">
                                        <tr>
                                            <th>No</th>
                                            <th>Elemento</th>
                                            <th>Junta</th>
                                            <th>Indicación</th>
                                            <th>Calificacion</th>
                                            <th>Observaciones</th>
                                            <th>Ver_Imagenes</th>
                                            <th></th>
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
    </section>
@endsection

<!-- Modal Editar Juntas -->
<div class="modal fade" id="modal-juntas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display: none">
                    <input type="hidden" id="id_juntas">
                    <input type="hidden" name="id_inf_part_magneticas" id="id_inf_part_magneticas"
                        value="{{ $informePartesMagnetica->id }}">
                    {{ $juntasInformePartesMagnetica = new App\Models\JuntasInformePartesMagneticas() }}
                </div>
                @include('juntas-informe-partes-magneticas.form')
            </div>
        </div>
    </div>
</div>

<!-- Modal Imagen -->
<div class="modal fade" id="juntas-imagenes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imagenes Juntas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload"
                    action="javascript:void(0)">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="junta_id" id="junta_id">
                                <input type="hidden" name="file_path" id="file_path" value="">
                                <input type="file" name="file" placeholder="Seleccione un archivo" id="file">
                                <span class="text-danger">{{ $errors->first('file') }}</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Subir</button>
                        </div>
                    </div>
                </form>

                {{-- Listado imaganes --}}
                <div class="row" id="listado-imagenes">
                </div>

            </div>
        </div>
    </div>
</div>



@section('scripts')
    <script src="{{ asset('js/cruds/juntas_informe_partes_magneticas.js') }}"></script>

    {{-- Script para las imagenes --}}
    <script type="text/javascript">
        var txtIdJunta = document.querySelector("#junta_id");

        function mostrarModalImagenes(IdJunta) {
            txtIdJunta.value = IdJunta;
            cargarImagenes();
        }

        function cargarImagenes() {
            var div = document.getElementById('listado-imagenes');
            div.innerHTML = "";

            var currentUrl = "{{ url('juntas-partes-magneticas-imagenes/api_getByIdJunta') }}" + "/" +
                txtIdJunta.value;

            $.ajax({
                type: 'GET',
                url: currentUrl,
                success: (data) => {
                    var res = JSON.parse(data);
                    console.log(data);

                    var img = "";
                    var file_path = "";
                    for (let i = 0; i < res.length; i++) {
                        file_path = res[i].file_path + "";
                        delefile = "eliminarImagen(" + "'" + res[i].id + "'" + ")";
                        var url = "{{ url('storage/') }}";
                        url = url + "/" + res[i].file_path;

                        img += '<div class="col-md-3 col-12">';
                        img += '<img  height="180vh" width="180vw" ' + ' src="' + url + '" />';
                        img += '<span  style="cursor: pointer;color: #ff331c;"  onclick="' + delefile +
                            '">Eliminar</span></div>';
                    }


                    div.innerHTML += img;

                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function eliminarImagen(id) {
            var currentUrl = "{{ url('juntas-partes-magneticas-imagenes/api_delete') }}" + "/" + id;

            $.ajax({
                type: 'POST',
                url: currentUrl,
                success: (data) => {
                    cargarImagenes();
                },
                error: function(data) {
                    console.log(data);
                }
            });

        }

        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            cargarImagenes();

            $('#laravel-ajax-file-upload').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('juntas-partes-magneticas-imagenes/api_add') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        this.reset();
                        console.log(data);
                        cargarImagenes();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
    <style>
        #inspect-canvas,
        #review-canvas {
            border: 1px solid #060606;
            border-radius: .25rem;
        }
    </style>
@endsection
