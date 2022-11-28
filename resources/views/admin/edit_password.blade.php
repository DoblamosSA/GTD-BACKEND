@extends('layouts.dashboard')

@section('content')
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
            <div class="card-header">
                <h3>Cambiar password</h3>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">

                <form method="post" action="{{ route('admin.change_password', $data['user']->id) }}">
                    @method('PATCH')
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>Usuario</label>
                            <input type="text" class="form-control" value="{{ $data['user']->name }}" name="name"
                                id="name" required readonly>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>Email address</label>
                            <input type="email" class="form-control" value="{{ $data['user']->email }}" name="email"
                                id="email" readonly>
                        </div>
                    </div> --}}


                    <div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <label>Password</label>
                                <input type="password" class="form-control" value="" name="password" id="password" required
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <label>Password confirmacion</label>
                                    <input type="password" class="form-control" value="" name="password_confirmation" id="password_confirmation" required required autocomplete="off">
                                <div style="margin-top: 7px;" id="CheckPasswordMatch"></div>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <button id="enviar" type="submit" class="btn btn-primary boton-guardar-registro">Guardar</button>

                    </div>



                </form>

            </div>
        </div>
    </div>
@endsection

