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
                            {{ __('Laminas') }}
                        </span>
                    </div>

                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <a href="{{route('Laminas.create')}}" class="btn btn-primary"><i></i>
                            Nueva Lamina
                        </a>


                    </div>
                </div>
                <br>
                @if (session('success'))
                <div class="alert alert-info">
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

                            <th>Codigo</th>
                            <th>Descripción</th>
                            <th>Calibre</th>
                            <th>Acciones</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laminas as $lamina)
                        <tr>
                            <td>{{ $lamina->Codigo }}</td>
                            <td>{{ $lamina->Descripcion }}</td>
                            <td>
                                <ul>
                                    @foreach($lamina->calibres as $calibre)
                                    <li>{{ $calibre->Calibre }} precio KG:   ${{ $calibre->pivot->precio }}</li>
                                    @endforeach
                                </ul>

                            </td>
                            <td>
                                <form action="{{ route('Laminas.destroy', $lamina->id) }}" method="POST"
                                    class="formulario-eliminar">


                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm "><i
                                            class="fa fa-fw fa-trash"></i></button>
                                    <a class="btn btn-sm btn-success" href="{{route('Laminas.edit',$lamina->id)}}"><i
                                            class="fa fa-fw fa-edit"></i></a>
                                </form>
                            </td>
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