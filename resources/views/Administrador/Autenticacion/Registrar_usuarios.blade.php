@extends('layouts.dashboard')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Registro de Usuarios</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">

                        <form method="post" action="{{ url('api/V1/register') }}">
                            @method('POST')
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Usuario</label>
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" value="" name="password" id="password"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="Nombre_Empleado" class="form-label">Nombre completo empleado</label>
                                <input type="text" class="form-control" value="" name="Nombre_Empleado" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Password Confirmación</label>
                                <input type="password" class="form-control" value="" name="password_confirmation"
                                    id="password_confirmation" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Rol</label>
                                <select class="form-control" name="role" id="role" required>
                                    @foreach($data['roles'] as $role)
                                        <option value="{{ $role->name }}">{{ strtoupper($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="ln_solid"></div>
                            <button type="submit" class="btn btn-primary boton-guardar-registro">Guardar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection
