@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="row  text-danger">
        <div class="row col-12">
            @if (count($errors) > 0)
            <div class="error mensaje-error-validacion">
                <ul>
                    @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    @if(session()->has('success'))
    <div id="success-alert" class="alert alert-success ">
        {{ session()->get('success') }}
    </div>
    @endif

    <br>
    <div class="card card-default">
        <div class="card-header">
            <h3>Listado Usuarios</h3>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
            <div class="row col-12">
                <a href="{{ route('admin.create_user')}}" class="btn btn-primary boton-agregar-registro">Agregar
                    Registro <i class="fa fa-plus"></i></a>
            </div>


            <table id="datatableinfo" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Usuario </th>
                        <th>Nombre Empleado </th>
                        <th>Role </th>
                        <th>Estado</th>

                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['users'] as $item)
                    <tr>
                        <td>
                            {{ $item->getFullName() }}
                        </td>

                        <td>{{ $item->Nombre_Empleado}}</td>
                        <td>{{ $item->getRol() }}</td>
                        <td>
                            @if ($item->deleted_at === null)
                            <a href="{{  route('admin.disable_user',$item->id)}}"> Desactivar</a>
                            @endif

                            @if ($item->deleted_at !== null)
                            <a href="{{  route('admin.enable_user',$item->id)}}">Activar </a>
                            @endif
                        </td>

                        <td>
                            <div style="width: 100px;">
                                <a href="{{ route('admin.edit_password',$item->id)}}"> <i
                                        class="fa fa-key fa-lg icono-editar"
                                        style="color: rgb(59 70 71);margin-right: 10px;"></i></a>
                                <a href="{{ route('admin.edit_user',$item->id)}}"> <i
                                        class="fa fa-edit fa-lg icono-editar"></i></a>
                                <a style="margin-left: 10px;" href="{{ route('admin.delete_user',$item->id)}}"> <i
                                        class="fa fa-trash fa-lg icono-eliminar" style="color: red"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Usuario</th>
                      <th>Nombre Empleado</th>
                        <th>Role </th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>
</div>


@endsection