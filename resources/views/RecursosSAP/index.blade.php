@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')
<br>
<style>
.btn-estado {
    width: 150px;
    /* ajustar el ancho según sus necesidades */
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('RECURSOS') }}
                        </span>
                    </div>


                </div>
                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <a href="{{url('Recursos-SAP')}}" class="btn btn-primary"><i></i>
                            Importar Recursos

                        </a>

                    </div>
                </div>
                <br>

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Codigo</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Tiempo</th>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($recursos as $row)
                        <tr>

                            <td>{{$row->id}}</td>
                            <td>{{$row->Code}} </td>
                            <td>{{$row->Name}}</td>
                            <td>${{number_format($row->Cost1)}}</td>
                            <td>{{$row->UnitOfMeasure}}</td>

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
@endsection