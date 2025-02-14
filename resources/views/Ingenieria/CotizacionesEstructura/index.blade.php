﻿@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" >
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" >
                            {{ __('Seguimiento Cotizaciones Formaletas') }}
                        </span>



                    </div>


                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="@mdo">Registro Clientes</button>
                        <a class="btn btn-sm btn-primary" href="" target="_blank"><i
                                class="fas fa-file-pdf"></i>Exportar PDF </a> -->
                        <a href="{{route('export.export')}}" class="btn  btn-success"><i class="fas fa-file-export"></i>
                            Exportar Excel

                        </a>

                        <!-- <a href="{{route('estructurasMetalicas.import')}}" class="btn  btn-success"><i
                                class="fas fa-file-import"></i>
                            Importar

                        </a> -->
                        <a href="{{route('cotizacion.create')}}" class="btn btn-primary"><i></i>
                            Crear Nuevo

                        </a>
                        <a href="" class="btn btn-warning"><i></i> Indicadores
                        </a>

                    </div>


                </div>
                <br>



                @if ($errors->any())
                <div class="alert alert-danger">

                    <p>Corrige los siguientes errores: El cliente no se guardo correctamente</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Clientes Doblamos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="modal-body">

                                <form action="" method="post">

                                    @csrf
                                    <fieldset>
                                        <legend class="text-center header"> Registro Clientes</legend>

                                        <div class="form-group">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i
                                                    class="fa fa-user bigicon"></i></span>
                                            <div class="col-md-12">
                                                <input name="Empresa" type="text" placeholder="Empresa"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Nit" type="text" placeholder="Nit" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Contacto" type="text" placeholder="Contacto"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i
                                                    class="fa fa-envelope-o bigicon"></i></span>
                                            <div class="col-md-12">
                                                <input name="Correo" type="text" placeholder="Correo"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Telefono" type="text" placeholder="Telefono"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="box-footer mt20">
                                            <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                        </div>
                                        <br>
                                    </fieldset>
                                </form>



                            </div>

                        </div>
                    </div>
                </div>


                <table class="table table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Nombres</th>
                            <th>Telefono</th>
                            <th>#Obra</th>
                            <th>Nombre Obra</th>
                            <th>Lugar Obra</th>
                            <th>Fecha Recibido</th>
                            <th>Fecha Cotizada</th>
                            <th>Valor A.Iva</th>
                            <th>Valor Adjudicado</th>
                            <th>Tipologia</th>
                            <th>Estado</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($cotizacionEstructuras as $row)
                        <tr>

                            <td>{{$row->clientes->CardCode}}</td>
                            <td>{{$row->clientes->CardName}}</td>
                            <td>{{$row->clientes->Phone1}}</td>
                            <td>{{$row->Numero_Obra}}</td>
                            <td>{{$row->Nombre_Obra}}</td>
                            <td>{{$row->Lugar_Obra}}</td>
                            <td>{{$row->Fecha_Recibido}}</td>
                            <td>{{$row->Fecha_Cotizada}}</td>
                            <td>${{number_format($row->Valor_Antes_Iva)}}</td>
                            <td>${{number_format($row->Valor_Adjudicado)}}</td>
                            <td>{{$row->Tipologia}}</td>
                            @if($row->Estado == 'Perdida')
                            <td class="btn btn-danger btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'Seguimiento')
                            <td class="btn btn-sm btn-danger bg-warning btn-estado"> {{$row->Estado}}</td>
                            @elseif($row->Estado == 'Vendida')
                            <td class="btn btn-sm btn-success btn-estado"> {{$row->Estado}}</td>
                            @elseif($row->Estado == 'Pendiente')
                            <td class="btn btn-sm btn-danger btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'Cerrada')
                            <td class="btn btn-light btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'Adjudicada')
                            <td class="btn btn-light btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'No cotizada')
                            <td class="btn btn-light btn-estado">{{$row->Estado}}</td>
                            @endif



                            <td>
                                <form action="{{route('cotizacion.destroy',$row->id)}}" method="POST"
                                    class="formulario-eliminar" class="formulario-eliminar">

                                    @csrf
                                    @method('PUT')

                                    <a class="btn btn-sm btn-success" href="{{route('cotizacion.edit',$row->id)}}"><i
                                            class="fa fa-fw fa-edit "></i>
                                    </a>

                                    <button type="submit" class="btn btn-danger btn-sm "><i
                                            class="fa fa-fw fa-trash"></i></button>

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
    'Seguimiento de la cotización eliminado Correctamente!',
    'success'
)
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas eliminar el seguimiento?',
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
@endsection