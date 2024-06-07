@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <br>
    <div class="card card-default">
        <div class="card-header">
            <h4>LISTA DE CHEQUEO DIARIO</h4>
            <div class="clearfix"></div>
        </div>

        <!-- agregar usuario -->
        <div class="card-body">

            @if(auth()->user()->can('checkList'))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Inspección
            </button>
            @endif

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Formulario de Chequeo Diario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="" id="formularioChecklist">
                                @csrf

                                <div class="form-group">
                                    <label for="sede">Sede</label>
                                    <select class="form-control" id="sede" name="sede" required>
                                        <option value="">Seleccione una sede</option>
                                        <option value="La 33">La 33</option>
                                        <option value="Carabobo">Carabobo</option>
                                        <option value="Rionegro">Rionegro</option>
                                        <option value="Copacabana">Copacabana</option>
                                        <option value="Sabaneta">Sabaneta</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="campo">Seleccione un campo</label>
                                    <select class="form-control" id="campo" name="campo" required>
                                        <option value="">Seleccione un campo</option>
                                        <option value="camaras">Cámaras</option>
                                        <option value="telefonia">Telefonía</option>
                                        <option value="pantallas">Pantallas</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="estado_campo">Estado del Campo</label>
                                    <select class="form-control" id="estado_campo" name="estado_Campo" required>
                                        <option value="Funcionando">Funcionando</option>
                                        <option value="No funciona">No funciona</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comentarios">Comentarios</label>
                                    <textarea class="form-control" id="comentarios" name="comentarios"
                                        required></textarea>
                                </div>

                                <button type="button" class="btn btn-primary" id="agregarBtn">Agregar</button>
                            </form>
                            <!-- Fin del formulario -->

                            <!-- Tabla para mostrar los datos ingresados -->
                            <table class="table" id="tablaDatos">
                                <thead>
                                    <tr>
                                        <th>Sede</th>
                                        <th>Campo</th>
                                        <th>Estado del Campo</th>
                                        <th>Comentarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se agregarán las filas de datos ingresados -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="registrarBdBtn">Registrar BD</button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="datatableinfo" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SEDE</th>
                        <th>INSPECCION </th>
                        <th>ESTADO</th>
                        <th>COMENTARIOS </th>
                        <th>FECHA INSPECCION</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($inspeccion as $inspeccion)
                    <tr>
                        <td>{{$inspeccion->sede}}</td>
                        <td>{{$inspeccion->campo}}</td>
                        <td>{{$inspeccion->estado_Campo}}</td>
                        <td>{{$inspeccion->comentarios}}</td>
                        <td>{{$inspeccion->created_at}}</td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="container-fluid">
        <br>
        <div class="card card-default">
            <div class="card-header">
                <h4>TAREAS PENDIENTES</h4>
                <div class="clearfix"></div>
            </div>

            <!-- agregar usuario -->
            <div class="card-body">


                @if(auth()->user()->can('Tareas_pendientes'))
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">
                    REGISTRAR TAREA
                </button>
                @endif


                <div class="modal fade" id="registerModal" tabindex="-1" role="dialog"
                    aria-labelledby="registerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">


                                <h5 class="modal-title" id="registerModalLabel">Registrar Tarea</h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>

                            <div class="modal-body">
                                <form id="registrationForm" method="post" action="{{ url('Tareas-TI') }}">
                                    @method('POST')
                                    @csrf

                                    <div class="mb-3">
                                        <label for="Descripcion_Tarea" class="form-label">Comentarios de la
                                            tarea</label>
                                        <input type="text" class="form-control" value="{{ old('Descripcion_Tarea') }}"
                                            name="Descripcion_Tarea" id="Descripcion_Tarea" required>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <!-- Dentro del formulario -->
                                <button type="button" class="btn btn-primary boton-guardar-registro"
                                    id="submitForm">Guardar</button>

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
                                        <input type="password" class="form-control" name="password" id="password"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" required>
                                    </div>

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
                            <th>ID </th>
                            <th>TAREA </th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($tareas as $tareas)
                        <tr>
                            <td>{{$tareas->id}}</td>
                            <td>{{$tareas->Descripcion_Tarea}}</td>
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
            // Captura el evento de clic en el botón "Guardar"
            $("#submitForm").click(function() {
                // Recopila los datos del formulario
                var formData = $("#registrationForm").serialize();

                // Realiza una solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: "{{ url('Tareas-TI') }}",
                    data: formData,
                    success: function(response) {
                        // Maneja la respuesta exitosa aquí, por ejemplo, muestra un mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response
                                .message,
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
                                text: 'Error al registrar el usuario: ' + xhr
                                    .responseJSON.message,
                            });
                        }
                    }
                });
            });
        });
        </script>
        <script>
        $(document).ready(function() {
            var checklistDataArray = []; // Arreglo para almacenar los datos del checklist

            // Al hacer clic en "Agregar", captura los datos y agrega una fila a la tabla y al arreglo
            $('#agregarBtn').click(function() {
                var sede = $('#sede').val();
                var campo = $('#campo').val();
                var estadoCampo = $('#estado_campo').val();
                var comentarios = $('#comentarios').val();

                // Agregar los datos a la tabla
                var newRow = '<tr><td>' + sede + '</td><td>' + campo + '</td><td>' + estadoCampo +
                    '</td><td>' +
                    comentarios + '</td></tr>';
                $('#tablaDatos tbody').append(newRow);

                // Agregar los datos al arreglo
                var rowData = [sede, campo, estadoCampo, comentarios];
                checklistDataArray.push(rowData);

                // Limpiar los campos después de agregar
                $('#campo').val('');
                $('#estado_campo').val('Funcionando'); // Restablecer a "Funcionando" por defecto
                $('#comentarios').val('');
            });

            // Al hacer clic en "Registrar BD", enviar los datos al servidor
            $('#registrarBdBtn').click(function() {
                // Enviar los datos almacenados en el arreglo al servidor utilizando AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route("checklist.store") }}',
                    data: {
                        checklistData: checklistDataArray // Enviar el arreglo completo
                    },
                    success: function(response) {
                        // Manejar la respuesta del servidor (éxito o error)
                        console.log(response);
                        if (response === 'ok') {
                            // Limpiar la tabla después de registrar en la base de datos
                            $('#tablaDatos tbody').empty();
                            // Limpiar el arreglo
                            checklistDataArray = [];
                            // Cerrar el modal
                            $('#myModal').modal('hide');
                        } else {
                            // Manejar el caso de error si es necesario
                        }
                    },
                    error: function(xhr, status, error) {
                        // Manejar los errores
                        console.error(error);
                    }
                });
            });
        });
        </script>