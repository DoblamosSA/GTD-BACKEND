@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="row  text-danger">
            <div class="row col-12">
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


        @if(session()->has('success'))
        <div class="alert alert-success alerta">
            {{ session()->get('success') }}
        </div>
        @endif
    </div>

    <div class="card card-primary">
        <div class="card-header">
                <h3>Datos de usuario</h3>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <br />

                <form method="post" action="{{ route('profile_user.update_data_profile') }}">
                    @method('POST')
                    @csrf

                    <div class="row">
                        <div class="row col-12">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>Nombre</label>
                                <input type="text" class="form-control" value="{{ $data['user']->name }}" name="name" id="name">
                            </div>
                        </div>

                        <div class="row col-12">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $data['user']->email }}" name="email" id="email" required>
                            </div>
                        </div>
                        


                        <button type="submit" class="btn bg-primary float-right boton-guardar-registro">Aceptar</button>


                    </div>
                </form>


            </div>
        </div>
</div>


@endsection

@section('scripts')

<script>
    window.onload = function() {
        var duration = 1000; //2 seconds
        setTimeout(function() {
            $('.alerta').hide();
        }, duration);
    };
</script>

@endsection