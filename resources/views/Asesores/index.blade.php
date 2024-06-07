@extends('layouts.dashboard')

@section('template_title')
    Seguimiento Cotizaciones Estructura
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ez2kMw1Usf3z6AHQ5d1AuMQw8azAq4zWzX2buT5d7V4r3f5EmopKlJ5drDfiFgAW" crossorigin="anonymous">

<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Asesores doblamos') }}
                        </span>
                    </div>
                </div>

                <br>

                @if(auth()->user()->can('Registrar_Asesores'))
                <a class="btn btn btn-primary" data-toggle="modal" data-target="#create-user-modal"><i></i>Registrar Asesor</a>
                @endif

                <br>
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog" aria-labelledby="create-user-modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-user-modal-label">Registro Asesor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('Asesores.store') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col">
                                            <label>Nombre del Asesor</label>
                                            <input type="text" class="form-control @error('Nombre_Asesor') is-invalid @enderror" name="Nombre_Asesor" value="{{ old('Nombre_Asesor') }}" required autocomplete="Nombre_Asesor" autofocus placeholder="Nombre asesor"><br>
                                            <input type="text" class="form-control @error('correo_asesor') is-invalid @enderror" name="correo_asesor" value="{{ old('correo_asesor') }}" required autocomplete="correo_asesor" autofocus placeholder="Correo">
                                            @error('Nombre_Area')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Registrar') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de Edición -->
                <!-- Modal de Edición -->
                <div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit-user-modal-label">Editar Asesor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="edit-user-form" method="POST" action="">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="edit-Nombre_Asesor">Nombre del Asesor:</label>
                                        <input type="text" name="Nombre_Asesor" class="form-control" id="edit-Nombre_Asesor" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit-correo_asesor">Correo del Asesor:</label>
                                        <input type="text" name="correo_asesor" class="form-control" id="edit-correo_asesor" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Asesor</th>
                            <th>Correo</th>
                            <th>Fecha Creacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    @foreach($Asesor as $row)
                    <tbody>
                        <td>{{$row->id}}</td>
                        <td>{{$row->Nombre_Asesor}}</td>
                        <td>{{$row->correo_asesor}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal" data-target="#edit-user-modal" data-id="{{ $row->id }}" data-nombre="{{ $row->Nombre_Asesor }}" data-correo="{{ $row->correo_asesor }}">
                                <i class="fa fa-fw fa-pencil"></i>
                            </button>
                            <form action="{{route('Asesores.destroy', $row->id)}}" method="POST" class="formulario-eliminar">
                                @csrf
                                @method('PUT')
                                @if(auth()->user()->can('Eliminar_Asesor'))
                                <button type="submit" class="btn btn-danger btn-sm "><i class="fa fa-fw fa-trash"></i></button>
                                @endif
                            </form>
                        </td>
                    </tbody>
                    @endforeach

                    <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Area</th>
                            <th>Correo</th>
                            <th>Fecha Creacion</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-end">
                    {!! $Asesor->links() !!}
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

$('.edit-btn').on('click', function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    var correo = $(this).data('correo');

    // Actualizar el action del formulario
    $('#edit-user-form').attr('action', '{{ url('asesores') }}/' + id);

    $('#edit-Nombre_Asesor').val(nombre);
    $('#edit-correo_asesor').val(correo);

    $('#edit-user-modal').modal('show');
});

$(document).ready(function() {
    $('#edit-user-form').submit(function(e) {
        e.preventDefault();

        // Obtener la URL de la acción del formulario
        var url = $(this).attr('action');

        // Obtener el método del formulario (puede ser 'PUT' o 'PATCH')
        var method = $(this).find('input[name="_method"]').val() || 'POST';

        // Obtener los datos del formulario
        var formData = $(this).serialize();

        $.ajax({
            type: method,
            url: url,
            data: formData,
            success: function(response) {
                // Manejar la respuesta JSON aquí
                if (response.success) {
                    // Puedes mostrar un mensaje de éxito, recargar la página, o realizar otras acciones
                    console.log(response.message);
                } else {
                    // Puedes mostrar un mensaje de error o realizar otras acciones
                    console.error('Error al actualizar el asesor');
                }
            },
            error: function(error) {
                // Manejar errores de la solicitud AJAX
                console.error('Error en la solicitud AJAX', error);
            }
        });
    });
});
</script>


@endsection
