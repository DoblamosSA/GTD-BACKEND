@extends('layouts.dashboard')

@section('content')

<style>
    /* Estilos generales */
    .container-fluid {
        padding: 20px;
    }

    .card-primary {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .card-body {
        margin-top: 20px;
    }

    /* Estilos para los campos de entrada */
    .form-label {
        font-weight: bold;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
        margin-bottom: 15px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Estilos para el botón */
    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Estilos para el formulario */
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Otros estilos */
    .mb-3 {
        margin-bottom: 20px;
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
</style>

<div class="container-fluid">
    <div class="card card-primary">
        <div>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
            <form method="post" action="{{url('api/v1/usuarios/actualizar',$user->id)}}">
                @method('PUT')
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" value="{{$user->name }}" name="name" id="name" required>
                </div>

                <div class="mb-3">
                    <label for="Nombre_Empleado" class="form-label">Nombre completo del empleado</label>
                    <input type="text" class="form-control" value="{{$user->Nombre_Empleado}}" name="Nombre_Empleado" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select class="form-control" name="role" id="role" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $("form").submit(function(event) {
            event.preventDefault(); // Evita que el formulario se envíe normalmente

            // Serializa los datos del formulario
            var formData = $(this).serialize();

            $.ajax({
                type: "PUT",
                url: $(this).attr("action"),
                data: formData,
                success: function(response) {
                    // Mostrar mensaje de éxito con SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    });
                },
                error: function(xhr) {
                    // Mostrar mensaje de error con SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message
                    });
                }
            });
        });
    });
</script>

@endsection
