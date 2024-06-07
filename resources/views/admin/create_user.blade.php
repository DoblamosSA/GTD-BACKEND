@extends('layouts.dashboard')

@section('content')



<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Registro Usuarios</h1>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="container-fluid">

        <div class="row  text-danger">
            <div class="row col-12 col-xs-12">
                @if (count($errors) > 0)
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <div class="card card-primary">

            <div class="card-body">

                <form method="post" action="{{ route('admin.store_user') }}">
                    @method('POST')
                    @csrf
                    <div>
                        <div class="row">
                            <div class="row">
                                <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>Nombre completo</label>
                                    <input type="text" class="form-control" value="{{ old('nombres') }}"name="nombres" id="nombres" required>
                                </div> -->
                                <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>Apellidos</label>
                                    <input type="text" class="form-control" value="{{ old('apellidos') }}" name="apellidos" id="apellidos" required>
                                </div> -->
                                <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>Cedula</label>
                                    <input type="" class="form-control" value="{{ old('cedula') }}" name="cedula" id="cedula" required>
                                </div> -->
                                <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>Cargo</label>
                                    <input type="text" class="form-control" value="{{ old('cargo') }}" name="cargo" id="cargo" required>
                                </div> -->

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <label>Usuario</label>
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name"
                                    required>
                            </div>
                        </div>

                        {{-- <div class="row">
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>Email address</label>
                                    <input type="text" class="form-control" value="{{ old('email') }}" name="email"
                        id="email">
                    </div>
            </div> --}}

            <div class="row">
                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" value="" name="password" id="password" required>
                </div>
                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                    <label for="Nombre Empleado">Nombre completo empleado</label>
                    <input type="text" class="form-control" value="" name="Nombre_Empleado"
                        required>
                </div>
                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                    <label for="password_confirmation">Password Confirmacion</label>
                    <input type="password" class="form-control" value="" name="password_confirmation"
                        id="password_confirmation" required>
                </div>

            </div>


            <div class="row">
                <div class="form-group col-12 col-xs-12">
                    <label>Rol</label>
                    <br>
                    @foreach($data['roles'] as $item)
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="{{ $item->name }}" name="role"
                                {{ 2 == $item->name ? "checked" : "" }} required>
                            {{ strtoupper($item->name)  }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>



            <div class="ln_solid"></div>
            <button type="submit" class="btn btn-primary boton-guardar-registro">Guardar</button>

        </div>

    </div>
    </form>
    </div>


    </div>
</section>

<!-- /.content -->



</div>




@endsection