@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')

<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Creacion de calibres') }}
                        </span>

                    </div>

                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">


                        <a class="btn btn btn-primary" data-toggle="modal"
                            data-target="#create-user-modal"><i></i>Registrar Calibre
                        </a>

                    </div>
                </div>

                <br>
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                   
                </div>
                @endif

            
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog"
                    aria-labelledby="create-user-modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-user-modal-label">Registro Asesor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{url('Calibres/store')}}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col">
                                            <label>Numero de calibre</label>
                                            <input type="text"
                                                class="form-control @error('Nombre_Asesor') is-invalid @enderror"
                                                name="Calibre" value="" required autocomplete="" autofocus>


                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Registrar') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
		@foreach ($calibres as $calibre)
                <div class="modal fade" id="editar{{$calibre->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="editar{{$calibre->id}}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editar{{$calibre->id}}Label">Editar Calibre</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('calibres.update', $calibre->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Calibre">Calibre</label>
                                        <input type="text" class="form-control" id="Calibre" name="Calibre"
                                            value="{{$calibre->Calibre}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Calibre</th>
                            <th>Fecha creacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($calibres as $row)
                        <tr>

                            <td>{{$row->id}}</td>
                            <td>{{$row->Calibre}}</td>
                            <td>{{$row->created_at}}</td>

                            <td>

                                <form action="{{route('Calibres.destroy',$row->id)}}" method="POST" class="formulario-eliminar">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger btn-sm "><i
                                            class="fa fa-fw fa-trash"></i></button>
                                  <a class="btn btn-sm btn-success" href="#" data-toggle="modal"
                                        data-target="#editar{{$row->id}}"><i class="fa fa-fw fa-edit"></i></a>

                                </form>

                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Calibre</th>
                            <th>Fecha creacion</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>



            </div>

        </div>

    </div>
</div>

</div>

</div>
</div>
</div>


@endsection
@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- CSS only -->
@if (session('eliminar') == 'ok')
<script>
swal.fire(
    'Eliminado!',
    'Costo de no calidad eliminado con éxito!',
    'success'
)
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas eliminar el calibre?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '3085d6',
        CancelButtonColor: '#d33',
        CancelButtonText: 'yes, delete it!'

    }).then((result) => {
        if (result.value) {
            this.submit();
        }

    })
});
</script>