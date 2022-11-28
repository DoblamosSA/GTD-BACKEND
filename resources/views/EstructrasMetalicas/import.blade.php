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
                <form action="{{route('estructurasMetalicas-import.impStore')}}" method="POST" enctype="multipart/form-data"
                    accept=".csv,xlsx">

                    @csrf
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <p>Corrige los siguientes errores:</p>
                        <ul>
                            @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div>
                        <div >
                            <input type="file" name="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
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