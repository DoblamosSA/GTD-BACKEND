@extends('layouts.dashboard')

@section('template_title')
Nueva cotizacion
@endsection

@section('content')

<br>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Registro Clientes</span>
                </div> <br>
                @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                <form action="{{route('clientes.store')}}" method="POST" class="formulario-crear">
                    @csrf
                    @method('post')

                    <div class="form-row">

                        <div class="col">
                            <label>Empresa</label>
                            <input type="text" class="form-control" placeholder="Empresa " name="Empresa">

                        </div>
                        <div class="col">
                            <label>Nit</label>
                            <input type="text" class="form-control" placeholder="Nit " name="Nit">

                        </div>
                        <div class="col">
                            <label>Contacto</label>
                            <input type="text" class="form-control" placeholder="Contacto " name="Contacto">

                        </div>
                        <div class="col">
                            <label>Correo</label>
                            <input type="text" class="form-control" placeholder="Correo " name="Correo">

                        </div>

                        <div class="col">
                            <label>Telefono</label>
                            <input type="number" class="form-control" placeholder="Telefono " name="Telefono">

                        </div>


                     

                    </div>
                    <br>
                    <div class="box-footer mt20">
                            <button type="submit" class="btn btn-primary">Guardar Registro</button>
                        </div>
                    <br>





            </div>



            </form>




        </div>
    </div>
    </div>
    </div>
</section>


@endsection