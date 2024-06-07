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

        <!-- agregar usuario -->
        <div class="card-body">
            @if(auth()->user()->can('Agregar_usuarios'))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">
                Agregar Usuario
            </button>

            @endif
             <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog mw-100 w-75" role="document">
                    <div class="modal-content">

                        <div class="modal-header" style="background-color: #003366;">
                            <h5 class="modal-title" id="registerModalLabel" style="color: #fff;">Agregar Nuevo Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="registrationForm" method="post" action="{{ url('api/V1/register') }}">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" value="" name="password" id="password" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Password Confirmación</label>
                                            <input type="password" class="form-control" value="" name="password_confirmation" id="password_confirmation" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="Nombre_Empleado" class="form-label">Nombre completo empleado</label>
                                            <input type="text" class="form-control" value="" name="Nombre_Empleado" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Rol</label>
                                            <select class="form-control" name="role" id="role" required>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="usersap" class="form-label">Usuario SAP</label>
                                            <input type="text" class="form-control" name="usersap" placeholder="Opcional">
                                        </div>

                                        <div class="mb-3">
                                            <label for="usersap" class="form-label">Clave SAP</label>
                                            <input type="text" class="form-control" name="usersappassword" placeholder="Opcional">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="text" class="form-control" value="" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Usuario Aprobador</label>
                                            <select class="form-control" name="usuarioaprobador" id="role" required>
                                                <option value=""></option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->Nombre_Empleado }}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input custom-checkbox" id="EsAprobador" name="EsAprobador" value="1">
                                            <label class="form-check-label" for="EsAprobador">Es Aprobador</label>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <!-- Dentro del formulario -->
                            <button type="button" class="btn btn-primary boton-guardar-registro" id="submitForm">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resetPasswordModalLabel">Restablecer Contraseña</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="resetPasswordForm">
                                <input type="hidden" id="resetPasswordId" name="id" value="">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" required>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="resetPassword()">Guardar
                                Cambios</button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="datatableinfo" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Usuario </th>
                        <th>Nombre Empleado </th>
                        <th>Correo</th>
                        <th>Role </th>
                        <th>Acciones</th>
                    
                        <TH>Usuario aprobador</TH>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->Nombre_Empleado }}</td>
                          <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                            {{ $role->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @if(auth()->user()->can('Eliminar_Usuarios'))
                            <a class="btn btn-danger delete-user" data-user-id="{{ $user->id }}">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endif

                            @if(auth()->user()->can('Restablecer_contraseña'))
                            <a href="#" class="btn btn-info reset-password" data-user-id="{{ $user->id }}"
                                data-toggle="modal" data-target="#resetPasswordModal">
                                <i class="fa fa-key fa-lg icono-editar"></i>
                            </a>

                            @endif




                            <a class="btn btn-sm btn-success" href="{{ url('usuarios-edit',$user->id)}}">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                        </td>
                        <td>{{$user->usuarioaprobador}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Oyente para el botón de editar en la tabla
        $(document).on('click', '.editar-permiso', function() {
            var id = $(this).data('id');
            abrirModalEditar(id);
        });

        // Función para abrir el modal de edición y prellenar los campos
        function abrirModalEditar(id) {
            $('#editPermissionId').val(id);
            $('#editPermissionsModal').modal('show');
        }

        // Oyente para el botón "Guardar Cambios" en el modal de edición
        $('#editPermissionButton').click(function() {
            editarPermiso();
        });

        function editarPermiso() {
            var id = $('#editPermissionId').val();
            var formData = new FormData($("#editPermissionForm")[0]);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/v1/reset-password/${id}`,
                method: "PUT",
                data: formData,
                contentType: false, // Necesario cuando se usa FormData
                processData: false, // Necesario cuando se usa FormData
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Éxito', response.success, 'success');
                        $('#editPermissionsModal').modal('hide');
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Ocurrió un error al actualizar el permiso', 'error');
                    }
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.errors) {
                        var errorMessages = error.responseJSON.errors;
                        var errorMessage = Object.values(errorMessages).flat().join('<br>');
                        Swal.fire('Error de validación', errorMessage, 'error');
                    } else if (error.responseJSON && error.responseJSON.message) {
                        Swal.fire('Error', error.responseJSON.message, 'error');
                    } else {
                        Swal.fire('Error', 'Ocurrió un error al intentar actualizar el permiso',
                            'error');
                    }
                }
            });
        }
    });
    </script>



    <script>
    $(document).ready(function() {
        $(".delete-user").click(function() {
            var userId = $(this).data("user-id");

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el usuario',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/v1/usuarios/destroy') }}/" + userId,
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: response.message
                            }).then(function() {
                                location
                                    .reload(); // Recarga la página después de la eliminación
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = JSON.parse(xhr.responseText).message;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".edit-user").click(function() {
            var userId = $(this).data("user-id");

            // Cargar información del usuario mediante AJAX y llenar los campos del formulario
            $.ajax({
                url: "{{ url('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/v1/usuarios') }}/" +
                    userId, // Ajusta la URL a tu enrutamiento
                method: "GET",
                success: function(response) {
                    // Llenar los campos del formulario con la información del usuario
                    $("#name").val(response.name);
                    $("#Nombre_Empleado").val(response.Nombre_Empleado);
                    // Llena otros campos según sea necesario

                    // Abre el modal de edición
                    $("#editModal").modal('show');
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        });
    });
    </script>


    <script>
    function resetPassword() {
        var id = $('#resetPasswordId').val();
        $.ajax({
            url: `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/v1/reset-password/${id}`,
            method: "PUT",
            
            data: $('#resetPasswordForm').serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire('Éxito', response.success, 'success');
                    $('#resetPasswordModal').modal('hide');
                    location.reload();
                } else {
                    Swal.fire('Error', 'Ocurrió un error al restablecer la contraseña', 'error');
                }
            },
            error: function(error) {
                if (error.responseJSON && error.responseJSON.errors) {
                    var errorMessages = error.responseJSON.errors;
                    var errorMessage = Object.values(errorMessages).flat().join('<br>');
                    Swal.fire('Error de validación', errorMessage, 'error');
                } else if (error.responseJSON && error.responseJSON.message) {
                    Swal.fire('Error', error.responseJSON.message, 'error');
                } else {
                    Swal.fire('Error', 'Ocurrió un error al intentar restablecer la contraseña', 'error');
                }
            }
        });
    }


    $(document).ready(function() {
        // Oyente para el botón de restablecer contraseña en la tabla
        $(document).on('click', '.reset-password', function() {
            var userId = $(this).data('user-id');
            abrirModalResetPassword(userId);
        });

        // Función para abrir el modal de restablecimiento de contraseña y prellenar los campos
        function abrirModalResetPassword(userId) {
            // Limpiar los campos del formulario
            $("#password").val('');
            $("#password_confirmation").val('');

            // Establece el ID del usuario en el formulario
            $("#resetPasswordId").val(userId);

            // Abre el modal de restablecimiento de contraseña
            $("#resetPasswordModal").modal('show');
        }
    });
    </script>
  
  <script>
    $(document).ready(function() {
        // Captura el evento de clic en el botón "Guardar"
        $("#submitForm").click(function() {
            // Recopila los datos del formulario
            var formData = $("#registrationForm").serialize();
            
            // Realiza una solicitud AJAX
            $.ajax({
                type: "POST",
                url: "{{ url('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/V1/register') }}",
                data: formData,
                success: function(response) {
                    // Maneja la respuesta exitosa aquí, por ejemplo, muestra un mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Usuario registrado exitosamente: ' + response.message,
                    });
                    // Cierra el modal si es necesario
                    $("#registerModal").modal("hide");
                },
                error: function(xhr, status, error) {
                    // Maneja los errores de la solicitud aquí
                    if (xhr.responseJSON) {
                        // Si hay errores de validación, muestra los mensajes personalizados
                        var errorMessage = '';
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                errorMessage += message + '<br>';
                            });
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            html: errorMessage,
                        });
                    } else {
                        // Si no hay errores de validación, muestra un mensaje de error general
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al registrar el usuario: ' + xhr.responseJSON.message,
                        });
                    }
                }
            });
        });
    });
</script>
    