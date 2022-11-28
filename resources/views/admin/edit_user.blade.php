@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3>Editar Usuario</h3>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">

            <form method="post" action="{{ route('admin.update_user', $data['user']->id) }}">
                @method('PATCH')
                @csrf

                <div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>Usuario</label>
                            <input type="text" class="form-control" value="{{ $data['user']->name }}" name="name" id="name" required>
                        </div>
                        <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>Nombres</label>
                            <input type="text" class="form-control" value="{{ $data['user']->nombres }}" name="nombres" id="nombres" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" value="{{ $data['user']->apellidos }}" name="apellidos" id="apellidos" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            </label>Cedula</label>
                            <input type="text" class="form-control" value="{{ $data['user']->cedula }}" name="cedula" id="cedula" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>cargo</label>
                            <input type="text" class="form-control" value="{{ $data['user']->cargo }}" name="cargo" id="cargo" required>
                        </div>
                         -->
                    </div>
                    
                    
                   

                    {{-- <div class="row">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>Email address</label>
                            <input type="email" class="form-control" value="{{ $data['user']->email }}" name="email" id="email">
                        </div>
                    </div> --}}
                    
                    
                    <div class="row">
                        <div class="form-group col-12 col-xs-12">
                            <label>Rol</label>
                            <br>
                            @foreach($data['roles'] as $item)
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="{{ $item->name }}" name="role" {{ strtoupper($item->name) === trim(strtoupper($data['user']->getRol())) ? "checked" : "" }} required>
                                    {{ strtoupper($item->name)  }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <button type="submit" class="btn btn-primary boton-guardar-registro">Guardar</button>

                </div>

            

            </form>
            
        </div>
    </div>
</div>




@endsection