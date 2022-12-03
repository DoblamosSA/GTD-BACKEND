@extends('layouts.dashboard')



@section('content')
    <br><br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Informe Partes Magnetica') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('informe-partes-magneticas.create') }}"
                                    class="btn btn-primary btn-sm float-right" data-placement="left">
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
                                    <form action="{{route('informe-partes-magneticas.index')}}" method="GET">
                                        <div class="btn-group">

                                        <input type="text" name="busqueda" class="form-control"> 
                                        <input type="submit" value="buscar" class="btn bg-gradient-success ml-2">

                                        </div>

                                        
                                    </form>


                                </div> -->
                                    
                                </form>
                            </div>
                            
                            </div>

                            <table class="table table-striped table-hover"  id="datatableinfo">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Proyecto</th>
                                        <th>Fecha</th>
                                        <th>Sitio Inspeccion</th>
                                        <th>Cod Acep Rechazo</th>
                                        <th>Calidad Material B</th>
                                        <th>Proceso Soldadura</th>
                                        
                                        {{-- <th>Espesor Material B</th> --}}
                                        {{-- <th>Inspeccionador</th>
										<th>Nivel</th>
										<th>Reviso</th>
										<th>Nivelreviso</th> --}}

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($informePartesMagneticas as $informePartesMagnetica)
                                        <tr>
                                            <td>{{  $informePartesMagnetica->id }}</td>

                                            <td>{{ $informePartesMagnetica->proyecto }}</td>
                                            <td>{{ $informePartesMagnetica->fecha }}</td>
                                            <td>{{ $informePartesMagnetica->sitio_inspeccion }}</td>
                                            <td>{{ $informePartesMagnetica->cod_acep_rechazo }}</td>
                                            <td>{{ $informePartesMagnetica->calidad_material_b }}</td>
                                            <td>{{ $informePartesMagnetica->proceso_soldadura }}</td>
                                           
                                            {{-- <td>{{ $informePartesMagnetica->espesor_material_b }}</td> --}}
                                            {{-- <td>{{ $informePartesMagnetica->inspeccionador }}</td>
											<td>{{ $informePartesMagnetica->nivel }}</td>
											<td>{{ $informePartesMagnetica->reviso }}</td>
											<td>{{ $informePartesMagnetica->nivelreviso }}</td> --}}

                                            <td>
                                                <form
                                                    action="{{ route('informe-partes-magneticas.destroy', $informePartesMagnetica->id) }}"
                                                    method="POST"  class="formulario-eliminar">
                                                    {{-- <a class="btn btn-sm btn-primary " href="{{ route('informe-partes-magneticas.show',$informePartesMagnetica->id) }}"><i class="fa fa-fw fa-eye"></i> </a> --}}

                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('reportes-pdf.partes-magneticas', $informePartesMagnetica->id) }}"
                                                        target="_blank"><i class="fas fa-file-pdf"></i> </a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('informe-partes-magneticas.edit', $informePartesMagnetica->id) }}"><i
                                                            class="{{ App\Models\User::find(Auth::user()->id)->getRol()=="ADMINISTRADOR" ? "fa fa-fw fa-edit" : "fa fa-fw fa-eye" }}"></i> </a>
                                                    @csrf
                                                    {{-- @method('DELETE') --}}
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Desea eliminar el registro?');"><i
                                                            class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $informePartesMagneticas->links() !!} --}}
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

