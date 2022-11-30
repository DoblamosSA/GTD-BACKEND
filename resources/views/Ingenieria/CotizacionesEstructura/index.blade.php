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
                            {{ __('Seguimiento Cotizaciones Estructura') }}
                        </span>

                        <div class="float-right">
                            <a href="{{route('cotizacion.create')}}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Crear Nuevo') }}
                            </a>
                        </div>

                    </div>


                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">
                        <a class="btn btn-sm btn-primary" href="" target="_blank"><i
                                class="fas fa-file-pdf"></i>Exportar PDF </a>
                        <a href="{{route('export.export')}}" class="btn btn-sm btn-success"><i
                                class="fas fa-file-export"></i> Exportar Excel

                        </a>

                        <a href="{{route('cotizacion.import')}}" class="btn btn-sm btn-success" ><i class="fas fa-file-import"></i>
                            Importar

                        </a>


                    </div>


                </div>
                <br>




                <table class="table table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>#Obra</th>
                            <th>Empresa o Cliente</th>
                            <th>Fecha de Recibo</th>
                            <th>Nombre de la Obra</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Fecha Cotizada</th>
                            <th>Valor Antes Iva</th>
                            <th>Contacto</th>
                            <th>Area(m/2)</th>
                            <th>$/m2</th>
                            <th>Incluye Montaje</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($cotizacionEstructuras as $row)
                        <tr>


                            <td>{{$row->Numero_Obra}}</td>
                            <td>{{$row->Empresa_Cliente}}</td>
                            <td>{{$row->Fecha_Recibido}}</td>
                            <td>{{$row->Nombre_Obra}}</td>
                            <td>{{$row->Descripcion}}</td>
                            <td>
                            @if($row->Estado == 'Perdida')
                            <span style="color:red;">{{$row->Estado}}</span>
                            @elseif($row->Estado == 'Seguimiento')
                            <span style="color:#ff7514;">{{$row->Estado}}</span>
                            @elseif($row->Estado == 'Vendida')
                            <span style="color:green;">{{$row->Estado}}</span>
                            @endif

                            </td>
                            <td>{{$row->Fecha_Cotizada}}</td>
                            </td>
                            <td>{{number_format($row->Valor_Antes_Iva)}} </td>
                            <td>{{$row->Contacto}}</td>
                            <td>{{$row->AreaM2}}</td>
                            <td>{{number_format($row->m2)}}</td>
                            <td>{{$row->Incluye_Montaje}}</td>
                           

                            <td>
                                <form action="{{route('cotizacion.destroy',$row->id)}}" method="POST"
                                    class="formulario-eliminar" class="formulario-eliminar">

                                    @csrf
                                    @method('PUT')

                                    <a class="btn btn-sm btn-success" href="{{route('cotizacion.edit',$row->id)}}"><i
                                            class="fa fa-fw fa-edit "></i>
                                    </a>

                                    <button type="submit" class="btn btn-danger btn-sm "><i
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
        title: 'Estas seguro que deseas eliminar el seguimiento?',
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