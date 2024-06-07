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
                            {{ __('CONSUMIBLES') }}
                        </span>



                    </div>


                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <a href="{{route('Materiales.index')}}" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Materia prima
                        </a>


                        <a href="{{url('Materiales-consumible')}}" class="btn btn-primary"><i></i>
                            Importar Consumibles

                        </a>

                    </div>
                </div>
                <br>
                <nav class="navbar navbar-light">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <form class="form-inline" method="GET" action="{{ url('Materiales-consumibles') }}">
                                <input type="text" class="form-control mr-sm-2" name="query" aria-label="Search"
                                    placeholder="Buscar..." value="{{ $query ?? '' }}">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                            </form>
                        </li>
                    </ul>
                </nav>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Codigo</th>
                            <th>Descripción</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consumibles as $row)
                        <tr>

                            <td>{{$row->id}}</td>
                            <td>{{$row->ItemCode}}</td>
                            <td>{{$row->ItemName}}</td>




                        </tr>

                        @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-end">
                    {!! $consumibles->links() !!}
                </div>





            </div>
        </div>

    </div>

</div>
</div>
</div>
@endsection