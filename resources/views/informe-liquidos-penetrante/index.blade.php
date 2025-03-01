@extends('layouts.dashboard')



@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Informe Liquidos Penetrante') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('informe-liquidos-penetrante.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nuevo') }} <i class="fa fa-plus"></i>
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="row col-12 mb-3">
                                <!-- <form   action="{{ route('informe-liquidos-penetrante.index') }}" method="GET"> -->
                                <!-- <div class="d-md-flex justify-content-md-end">
                                    <form action="{{route('informe-liquidos-penetrante.index')}}" method="GET">
                                        <div class="btn-group">

                                        <input type="text" name="busqueda" class="form-control"> 
                                        <input type="submit" value="buscar" class="btn bg-gradient-success ml-2">

                                        </div>

                                        
                                    </form>


                                </div> -->
                                    
                                </form>
                            </div>


                            <table class="table table-striped table-hover" id="datatableinfo">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>                                        
										<th>Nombre Proyecto</th>
										<th>Fecha</th>
										<th>Lugar Inspeccion</th>
										<th>Calidad Material Base</th>
										<th>Proceso Soldadura</th>
                                        
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($liquidosPenetrantes as $liquidosPenetrante)
                                        <tr>
                                            <td>{{  $liquidosPenetrante->id }}</td>                                            
											<td>{{ $liquidosPenetrante->nombre_proyecto }}</td>
											<td>{{ $liquidosPenetrante->fecha }}</td>
											<td>{{ $liquidosPenetrante->sitio_inspeccion }}</td>
											<td>{{ $liquidosPenetrante->calidad_material_base }}</td>
											<td>{{ $liquidosPenetrante->proceso_soldadura }}</td>
                                            
                                            <td>
                                                <form action="{{ route('informe-liquidos-penetrante.destroy',$liquidosPenetrante->id) }}" method="POST" class="formulario-eliminar">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('reportes-pdf.liquidos-penetrante',$liquidosPenetrante->id) }}" target="_blank"><i class="fas fa-file-pdf"></i> </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('informe-liquidos-penetrante.edit',$liquidosPenetrante->id) }}"><i class="{{ App\Models\User::find(Auth::user()->id)->getRol()=="ADMINISTRADOR" ? "fa fa-fw fa-edit" : "fa fa-fw fa-eye" }}"></i> </a>
                                                    @csrf
                                                    {{-- @method('DELETE') --}}
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash" ></i> </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $liquidosPenetrantes->links() !!} --}}
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
    'Seguimiento de la cotización eliminado Correctamente!',
    'success'
)
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas eliminar el informe?',
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
@endsection

