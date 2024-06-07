    @extends('layouts.dashboard')

    @section('content')

    <style>
.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.permission-icon {
    font-size: 20px;
    color: #3498db;
    margin-right: 5px;
}

.permission-label {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
}

.label-danger {
    background-color: #e74c3c;
    color: #fff;
}

.label-warning {
    background-color: #f39c12;
    color: #fff;
}

.label-success {
    background-color: #2ecc71;
    color: #fff;
}

.permission-checkmark {
    color: #27ae60;
    font-size: 18px;
    margin-right: 5px;
}
    </style>


    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" class="">
                        <h4 class="card-title">ROLES Y PERMISOS</h4>
                    </div>

                    <div class="card-body">
                        <div class="row col-12">
                            @if(auth()->user()->can('Agregar_Rol'))
                            <a href="#" class="btn btn-primary boton-agregar-registro" data-toggle="modal"
                                data-target="#myModal">
                                Agregar Rol <i class="fa fa-plus"></i>
                            </a>
                            @endif
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered permissions-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre del Rol</th>
                                        <th scope="col">Permisos</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                @php
                                                $permissions = $role->permissions->chunk(3);
                                                @endphp
                                                @foreach ($permissions as $column)
                                                <div class="permission-column">
                                                    @foreach ($column as $permission)
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="permission-checkmark">&#10003;</span>
                                                        <i class="fas {{ $permission->icon }} permission-icon"
                                                            style="color: {{ $permission->color }};"></i>
                                                        <span
                                                            class="permission-label label-{{ $permission->color }}">{{ $permission->name }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Acciones">
                                                @if(auth()->user()->can('Editar_Rol'))
                                                <button type="button" class="btn btn-success editar-permiso">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @endif
                                                @if(auth()->user()->can('Eliminar_Roles'))
                                                <button type="button" class="btn btn-danger eliminar-permiso">
                                                    <i class="fas fa-trash"></i>
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
    </div>


 
    <!-- Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Rol</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Asegúrate de que el formulario englobe todo el contenido del modal -->
                <form id="crearRolForm" action="{{ url('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/v1/roles/store') }}" method="post">
                    @csrf <!-- Agrega el token CSRF -->

                    <div class="form-group">
                        <label for="nombreRol">Nombre del Rol:</label>
                        <input type="text" class="form-control" id="nombreRol" name="nombre"
                            placeholder="Ingrese el nombre del rol" required>
                    </div>
                    <div class="form-group row">
                        @foreach($permisos as $permiso)
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="permiso_{{ $permiso->id }}"
                                    name="permisos[]" value="{{ $permiso->id }}">
                                <label class="custom-control-label"
                                    for="permiso_{{ $permiso->id }}">{{ $permiso->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Mueve los botones de acción dentro del formulario -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary guardar-rol-btn" id="guardarRol">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    
    <script>
$(document).ready(function() {
   $('#crearRolForm').on('submit', function(e) {
      e.preventDefault();
      
      $.ajax({
         url: $(this).attr('action'),
         type: $(this).attr('method'),
         data: $(this).serialize(),
         success: function(response) {
            // Mostrar notificación de éxito
            Swal.fire('Éxito', response.message, 'success');
            // Recargar la página después de 1 segundo
            setTimeout(function() {
               location.reload();
            }, 60);
         },
         error: function(xhr, status, error) {
            // Mostrar notificación de error
            Swal.fire('Error', 'Error al crear el rol: ' + xhr.responseJSON.error, 'error');
         }
      });
   });
});
</script>


    @endsection