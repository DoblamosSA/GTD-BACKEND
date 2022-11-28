@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configuracion tramites</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard</h3>


                        </div>
                        <div class="card-body">

                            
                            <div class="row">
                                          <div id="area1" class="col-sm-12 col-md-2   connectedSortable">
                                    <div class="border-box">
                                        <div class="small-box bg-aqua">
                                            <div class="inner inner-box">
                                                <h2>Admin usuarios</h2>
                                            </div>
                                            <a href="{{ route('informe-partes-magneticas.index') }}" style="color: black"
                                                class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>


                       
                            </div>


                            <div class="row">
                                <div id="area1" class="col-sm-12 col-md-2 connectedSortable">
                                    <div class="border-box">
                                        <div class="small-box bg-aqua">
                                            <div class="inner inner-box">
                                                <h2>Partes magneticas</h2>
                                            </div>
                                            <a href="{{ route('informe-partes-magneticas.index') }}" style="color: black"
                                                class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="area1" class="col-sm-12 col-md-2   connectedSortable">
                                    <div class="border-box">
                                        <div class="small-box bg-aqua">
                                            <div class="inner inner-box">
                                                <h2>Partes magneticas</h2>
                                            </div>
                                            <a href="{{ route('informe-partes-magneticas.index') }}" style="color: black"
                                                class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="area1" class="col-sm-12 col-md-2   connectedSortable">
                                    <div class="border-box">
                                        <div class="small-box bg-aqua">
                                            <div class="inner inner-box">
                                                <h2>Partes magneticas</h2>
                                            </div>
                                            <a href="{{ route('informe-partes-magneticas.index') }}" style="color: black"
                                                class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="area1" class="col-sm-12 col-md-2   connectedSortable">
                                    <div class="border-box">
                                        <div class="small-box bg-aqua">
                                            <div class="inner inner-box">
                                                <h2>Partes magneticas</h2>
                                            </div>
                                            <a href="{{ route('informe-partes-magneticas.index') }}" style="color: black"
                                                class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <!-- /.card-body -->

                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="{{ asset('js/cruds/horarios_citas.js') }}"></script>
@endsection

<!-- /.modal -->
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Datos de tramite</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="mt-3 p-3" style="border-color: #d7d7d7;border-style: solid;">
                    <input type="hidden" id="id" name="id" value="3487">

                    <div class="form-group row">
                        <div class="col-12 col-md-4">
                            <label for="fecha" class="col-2 col-form-label">Fecha</label>
                            <div class="col-12">
                                <input id="fecha" name="fecha" type="date" class="form-control form-control-sm">
                            </div>
                        </div>

                    </div>


                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="calcular();">
                    Calcular
                </button>
                <button type="button" class="btn btn-primary" id="btnAdd" onclick="guardarDatos();">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary" id="btnUpdate" onclick="Update();">
                    Actualizar
                </button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
