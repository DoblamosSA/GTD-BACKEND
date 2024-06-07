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
                            {{ __('Areas Doblamos') }}
                        </span>




                    </div>


                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <a class="btn btn btn-primary" data-toggle="modal"
                            data-target="#create-user-modal"><i></i>Registrar Area
                        </a>



                    </div>



                </div>

                <br>
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog"
                    aria-labelledby="create-user-modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create-user-modal-label">Registro Centro de Costos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('Areas.store')}}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col">
                                            <label>Nombre de la area</label>
                                            <input type="text"
                                                class="form-control @error('Nombre_Area') is-invalid @enderror"
                                                name="Nombre_Area" value="{{ old('Nombre_Area') }}" required
                                                autocomplete="Nombre_Area" autofocus>

                                            @error('Nombre_Area')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Area</th>
                            <th>Fecha Creacion</th>

                            <th>Acciones</th>

                        </tr>
                    </thead>
                    @foreach($areas as $row)
                    <tbody>


                        <td>{{$row->id}}</td>
                        <td>{{$row->Nombre_Area}}</td>
                        <td>{{$row->created_at}}</td>

                        <td>

                        </td>
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Area</th>
                            <th>Fecha Creacion</th>

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
        title: 'Estas seguro que deseas eliminar el Costo de no calidad?',
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

@endsection