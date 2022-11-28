@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')
<br><br>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Registro seguimiento cotización</span>
                </div> <br>
                <form action="{{route('cotizacion.importStore')}}" method="POST" enctype="multipart/form-data" accept=".csv,xlsx">
                 
                    @csrf

                    <input type="file" name="file" class="form-control" >
                    <br>
                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Guardar Registro</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
  

</section>

    @endsection