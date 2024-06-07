@extends('layouts.dashboard')

@section('content')

<style>
.btn-estado {
    width: 150px;
    /* ajustar el ancho según sus necesidades */
}

/* Estilos personalizados para la navbar */
.navbar {
    background-color: #34495e;
}

.navbar-toggler-icon {
    background-color: #ecf0f1;
}

.navbar-brand {
    color: #ecf0f1;
    font-weight: bold;
}

.navbar-nav .nav-link {
    color: #ecf0f1;
    font-weight: 500;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #f39c12;
}

.navbar-nav .nav-item.active .nav-link {
    color: #f39c12;
}

.navbar-nav .dropdown-menu {
    background-color: #2c3e50;
    border: none;
    border-radius: 0;
}

.navbar-nav .dropdown-item {
    color: #ecf0f1;
    transition: background-color 0.3s ease;
}

.navbar-nav .dropdown-item:hover {
    background-color: #f39c12;
    color: #fff;
}

/* Estilos para la tabla */
#ventas-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#ventas-table th,
#ventas-table td {
    border: 1px solid #ced4da;
    padding: 8px;
    text-align: center;
}

#ventas-table th {
    background-color: #007bff;
    color: #fff;
}

#ventas-table tr:hover {
    background-color: #f1f1f1;
}

.indicador {
    background-color: white;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <br>
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">PERMISOS</a>
                        @if(auth()->user()->can('Registro_Permisos'))
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#permissionsModal">
                            Gestionar Permisos
                        </button>
                        @endif
                    </div>
                </nav>
                <br>

                <div class="card-body">
                    <!-- Tabla para mostrar los resultados de la consulta -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="datatableinfo">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre del permiso</th>
                                    <th scope="col">Guard Name</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permisos as $permiso)
                                <tr>
                                    <td>{{ $permiso->id }}</td>
                                    <td>{{ $permiso->name }}</td>
                                    <td>{{ $permiso->guard_name }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Acciones">

                                            @if(auth()->user()->can('Editar_permisos'))
                                            <button type="button" class="btn btn-sm btn-success editar-permiso"
                                                data-id="{{ $permiso->id }}" data-name="{{ $permiso->name }}"
                                                data-guard="{{ $permiso->guard_name }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                            @endif
                                            @if(auth()->user()->can('Eliminar_Permisos'))
                                            <button type="button" class="btn btn-sm btn-danger eliminar-permiso"
                                                data-id="{{ $permiso->id }}">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                            @endif
                                        </div>
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


    <!-- Modal de Agregar Permiso -->


    <!-- Modal de Agregar Permiso -->
    <div class="modal fade" id="permissionsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <!-- Cambio de modal-lg a modal-sm -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Agregar Permiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="permissionForm" method="POST" action="{{ url('/api/V1/permissions') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre del Permiso</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <input type="hidden" name="guard_name" value="web">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarPermiso" class="btn btn-primary" onclick="guardarPermiso()">Guardar
                        Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPermissionsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <!-- Cambio de modal-lg a modal-sm -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Agregar Permiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPermissionForm">
                        <input type="hidden" id="editPermissionId" name="id" value="">
                        <div class="form-group">
                            <label for="editPermissionName">Nombre</label>
                            <input type="text" class="form-control" id="editPermissionName" name="name" value="">
                        </div>
                        <div class="form-group">

                            <input type="hidden" class="form-control" id="editPermissionGuardName" name="guard_name"
                                value="web">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <!-- Cambio aquí: onclick directamente a la función editarPermiso() -->
                    <button type="button" class="btn btn-primary" onclick="editarPermiso()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
function guardarPermiso() {
    $.ajax({
        url: "https://rdpd.sagerp.co:59881/gestioncalidad/public/api/V1/permissions",
        method: "POST",
        data: $('#permissionForm').serialize(),
        success: function(response) {
            Swal.fire('Éxito', response.success, 'success'); // Mostrar mensaje de éxito del servidor
            // Cerrar el modal después de la alerta
            $('#permissionsModal').modal('hide');
            // Recargar la página para mostrar los cambios
            location.reload();
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.errors) {
                // Mostrar los mensajes de error de validación
                var errorMessages = error.responseJSON.errors;
                var errorMessage = Object.values(errorMessages).flat().join('<br>');
                Swal.fire('Error de validación', errorMessage, 'error');
            } else {
                Swal.fire('Error', 'Ocurrió un error al guardar el permiso',
                    'error'); // Mensaje de error genérico
            }
        }

    });
}

//ediccion del permiso
function editarPermiso() {
    var id = $('#editPermissionId').val();
    $.ajax({
        url: `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/V1/permissions/update/${id}`,
        method: "PUT",
        data: $('#editPermissionForm').serialize(),
        success: function(response) {
            // Si la solicitud se realiza con éxito, se ejecuta esta función
            if (response.success) {
                Swal.fire('Éxito', response.success, 'success'); // Mostrar mensaje de éxito
                $('#editPermissionsModal').modal('hide'); // Cerrar el modal
                location.reload(); // Recargar la página para mostrar los cambios
            } else {
                // Si la solicitud se realiza pero el servidor devuelve un error
                Swal.fire('Error', 'Ocurrió un error al actualizar el permiso', 'error');
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.errors) {
                var errorMessages = error.responseJSON.errors;
                var errorMessage = Object.values(errorMessages).flat().join('<br>');
                Swal.fire('Error de validación', errorMessage, 'error');
            } else if (error.responseJSON && error.responseJSON.message) {
                Swal.fire('Error', error.responseJSON.message,
                    'error'); // Mostrar mensaje de error específico del servidor
            } else {
                Swal.fire('Error', 'Ocurrió un error al intentar actualizar el permiso',
                    'error'); // Mensaje de error genérico
            }
        }

    });
}

//funcion para editar permisos
$(document).ready(function() {
    // Oyente para el botón de editar en la tabla
    $(document).on('click', '.editar-permiso', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var guard_name = $(this).data('guard');
        abrirModalEditar(id, name, guard_name);
    });

    // Función para abrir el modal de edición y prellenar los campos
    function abrirModalEditar(id, name, guard_name) {
        $('#editPermissionId').val(id);
        $('#editPermissionName').val(name);
        $('#editPermissionGuardName').val(guard_name);
        $('#editPermissionsModal').modal('show');
    }
});

//funcion para eliminar permisos
$(document).ready(function() {
    // Oyente para el botón de eliminar en la tabla
    $(document).on('click', '.eliminar-permiso', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarPermiso(id); // Llama a la función para eliminar el permiso
            }
        });
    });

    // Función para eliminar el permiso
    function eliminarPermiso(id) {
        $.ajax({
            url: `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/V1/permissions/destroy/${id}`, // Ajusta la URL aquí
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Éxito', response.message, 'success');
                    location.reload(); // Recargar la página para mostrar los cambios
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(error) {
                Swal.fire('Error', 'Ocurrió un error al intentar eliminar el permiso', 'error');
            }
        });
    }
});
</script>

@endsection