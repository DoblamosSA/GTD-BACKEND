@extends('layouts.dashboard')

@section('content')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">LICENCIAS DOBLAMOS</a>

                    </div>
                </nav>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">



                        <div class="d-md-flex justify-content-md-end">
                            <div class="col">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeviceModal">
                                    <i class="fas fa-plus"></i> Agregar Dispositivo
                                </button>
                            </div>
                        </div>

                    </div>



                </div>
                <br>
                <!-- Modal -->
                <div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #1c2a48;">
                                <h5 class="modal-title" id="addDeviceModalLabel" style="color: #fff;">Agregar Nueva licencia</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addDeviceForm">

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="deviceStatus">Estado:</label>
                                            <select class="form-control" name="Estado">
                                                <option value=""></option>
                                                <option value="Libre">Libre</option>
                                                <option value="Ocupada">Ocupada</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceStatus">Tipo Licencia:</label>
                                            <select class="form-control" name="Tipo_licencia">
                                                <option value=""></option>
                                                <option value="Office">Office</option>
                                                <option value="Adobe">Adobe</option>
                                                <option value="Tekla">Tekla</option>
                                                <option value="Idea">Idea</option>
                                                <option value="Pronest">Pronest</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Key:</label>
                                            <input type="text" class="form-control" name="key">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Correo Asociado:</label>
                                            <input type="text" class="form-control" name="correo_asociado">
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary" id="guardarLicenciaBtn">Guardar Licencia</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal de Edición -->
                <!-- Agrega este modal al final de tu vista -->
                <div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #1c2a48;">
                                <h5 class="modal-title" id="editDeviceModalLabel" style="color: #fff;">Editar Licencia</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para la edición -->
                                <form id="editDeviceForm">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="editEstado">Estado:</label>
                                            <select class="form-control" name="Estado" id="editEstado">
                                                <option value="Libre">Libre</option>
                                                <option value="Ocupada">Ocupada</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editTipoLicencia">Tipo Licencia:</label>
                                            <select class="form-control" name="Tipo_licencia" id="editTipoLicencia">
                                                <option value="Office">Office</option>
                                                <option value="Adobe">Adobe</option>
                                                <option value="Tekla">Tekla</option>
                                                <option value="Idea">Idea</option>
                                                <option value="Pronest">Pronest</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editKey">Key:</label>
                                            <input type="text" class="form-control" name="key" id="editKey">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editCorreoAsociado">Correo Asociado:</label>
                                            <input type="text" class="form-control" name="correo_asociado" id="editCorreoAsociado">
                                        </div>
                                    </div>
                                    <input type="hidden" name="editId" id="editId" value="">
                                    <button type="submit" class="btn btn-primary" id="actualizarLicenciaBtn">Actualizar Licencia</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


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


                <div id="indicador" class="d-none text-center">
                    <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-2"></i>
                    <p class="mb-0">Cargando...</p>
                </div>
                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead class="table-dark">
                        <tr>
                            <th style="font-size: 12px;">ID</th>
                            <th style="font-size: 12px;">TIPO LICENCIA</th>
                            <th style="font-size: 12px;">KEY</th>
                            <th style="font-size: 12px;">ESTADO</th>
                            <th style="font-size: 12px;">CORREO ASOCIADO</th>
                            <th style="font-size: 12px;">ACCIONES</th>

                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @foreach($licencias as $licencia)
                        <tr>
                            <td>{{ $licencia->id }}</td>
                            <td>{{ $licencia->Tipo_licencia }}</td>
                            <td>{{ $licencia->key }}</td>
                            <td class="{{ $licencia->Estado === 'Libre' ? 'estado-libre' : 'estado-ocupada' }}">
                                @if($licencia->Estado === 'Libre')
                                <span style="color: green;">
                                    <i class="fa fa-check-circle"></i> Libre
                                </span>
                                @else
                                <span style="color: red;">
                                    <i class="fa fa-times-circle"></i> Ocupada
                                </span>
                                @endif
                            </td>
                            <td>{{ $licencia->correo_asociado }}</td>
                            <td>
                                <button class="btn btn-outline-info btn-editar" data-id="{{ $licencia->id }}" data-estado="{{ $licencia->Estado }}" data-tipo-licencia="{{ $licencia->Tipo_licencia }}" data-key="{{ $licencia->key }}" data-correo-asociado="{{ $licencia->correo_asociado }}" title="Editar">
                                    <i class="fa fa-fw fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-eliminar" data-id="{{ $licencia->id }}" title="Eliminar">
                                    <i class="fa fa-fw fa-trash"></i>
                                </button>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#addDeviceForm').submit(function(event) {
            event.preventDefault();

            var formData = $(this).serialize();
            formData += '&_token=' + $('meta[name="csrf-token"]').attr('content'); // Agregar el token CSRF

            $.ajax({
                type: 'POST',
                url: 'api/GuardarLicencias',
                data: formData,
                success: function(response) {
                    // SweetAlert2 para éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Licencia creada correctamente',
                    });
                    location.reload();
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        // Manejar errores de validación
                        var validationErrors = xhr.responseJSON.errors;
                        var errorMessage = 'Error de validación:\n';
                        $.each(validationErrors, function(field, messages) {
                            errorMessage += field + ': ' + messages.join(', ') + '\n';
                        });

                        // SweetAlert2 para errores de validación
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            text: errorMessage,
                        });
                    } else {
                        // Manejar otros errores
                        var errorMessage = xhr.responseJSON.error || 'Error al crear la licencia';

                        // SweetAlert2 para otros errores
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Evento click en el botón de editar
        $('#datatableinfo').on('click', '.btn-editar', function() {
            var licenciaId = $(this).data('id');
            console.log('Licencia ID:', licenciaId);

            var estado = String($(this).data('estado'));
            var tipoLicencia = String($(this).data('tipo-licencia'));
            var key = String($(this).data('key'));
            var correoAsociado = String($(this).data('correo-asociado'));

            // Llenar los campos del modal con los datos de la licencia
            $('#editId').val(licenciaId);
            $('#editEstado').val(estado);
            $('#editTipoLicencia').val(tipoLicencia);
            $('#editKey').val(key);
            $('#editCorreoAsociado').val(correoAsociado);

            // Mostrar el modal de edición
            $('#editDeviceModal').modal('show');
        });

        // Resto del código existente...

        $('#editDeviceForm').submit(function(event) {
            event.preventDefault();

            // Obtener datos del formulario de edición
            var editData = $(this).serialize();
            editData += '&_token=' + $('meta[name="csrf-token"]').attr('content'); // Agregar el token CSRF
            console.log('ID a actualizar:', $('#editId').val());
            // Enviar una solicitud AJAX PUT al servidor
            $.ajax({
                type: 'PUT',
                url: 'api/ActualizarLicencia/' + $('#editId').val(),
                data: editData,
                success: function(response) {
                    // Manejar la respuesta exitosa
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message, // Puedes acceder a los mensajes de la respuesta
                    });

                    // Cerrar el modal de edición
                    $('#editDeviceModal').modal('hide');

                    // Recargar la página (puedes cambiar esto según tus necesidades)
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    var errorMessage = xhr.responseJSON.error || 'Error al actualizar la licencia';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        });

    });
</script>
<script>
    // Evento click en el botón de eliminar
    $('#datatableinfo').on('click', '.btn-eliminar', function() {
        var licenciaId = $(this).data('id');

        // Mostrar una alerta con SweetAlert para confirmar la eliminación
        Swal.fire({
            title: '¿Estás seguro que deseas eliminar la licencia?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                // Usuario confirmó, enviar solicitud AJAX DELETE al servidor
                $.ajax({
                    type: 'DELETE',
                    url: 'api/EliminarLicencia/' + licenciaId,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Manejar la respuesta exitosa
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message,
                        });

                        // Recargar la página (puedes cambiar esto según tus necesidades)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores
                        var errorMessage = xhr.responseJSON.error || 'Error al eliminar la licencia';

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                });
            }
        });
    });

</script>
@endsection