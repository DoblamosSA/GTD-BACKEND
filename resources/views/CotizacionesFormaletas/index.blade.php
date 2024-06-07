@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')
<br><br><br>
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
                            {{ __('Seguimiento Cotizaciones Formaletas') }}
                        </span>



                    </div>


                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <a href="" class="btn  btn-success"><i class="fas fa-file-export"></i>
                            Exportar Excel
                        </a>

                        <a href="{{url('cotizaciones-formaletas/create')}}" class="btn btn-primary"><i></i>
                            Nueva Cotizacion
                        </a>
                        <a href="{{url('Cotizaciones-formaletas-Indicadores')}}" class="btn btn-warning"><i></i> Indicadores
                        </a>
<a href="{{Url('Historico-formaletas')}}" class="btn btn-warning"><i></i> Historico
                        </a>
						  <a href="{{url('Analisis_venta')}}" class="btn btn-primary"><i></i>
                            Analisis venta
                        </a>
                    </div>
                </div>
                <br>
                @if ($errors->any())
                <div class="alert alert-danger">

                    <p>Corrige los siguientes errores: El cliente no se guardo correctamente</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Clientes Doblamos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="modal-body">

                                <form action="{{route('cotizaciones-formaletas.store')}}" method="post">

                                    @csrf
                                    <fieldset>
                                        <legend class="text-center header"> Registro Clientes</legend>

                                        <div class="form-group">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i
                                                    class="fa fa-user bigicon"></i></span>
                                            <div class="col-md-12">
                                                <input name="Empresa" type="text" placeholder="Empresa"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Nit" type="text" placeholder="Nit" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Contacto" type="text" placeholder="Contacto"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i
                                                    class="fa fa-envelope-o bigicon"></i></span>
                                            <div class="col-md-12">
                                                <input name="Correo" type="text" placeholder="Correo"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Telefono" type="text" placeholder="Telefono"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="box-footer mt20">
                                            <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                        </div>
                                        <br>
                                    </fieldset>
                                </form>



                            </div>

                        </div>
                    </div>
                </div>


                <table class="table table-striped" id="datatableinfo">
                    <thead class="table-dark">
                        <tr>
                            <th>#OBRA</th>
                            <th>NIT/CC</th>
                            <th>NOMBRES</th>
                            <th>TELEFONO</th>
                            <th>NOMBRE OBRA</th>
                            <th>LUGAR OBRA</th>
                            <th>FECHA RECIBIDO</th>
                            <th>FECHA COTIZADA</th>
                            <th>VALOR ADJUDICADO</th>
                            <th>TIPOLOGIA</th>
                            <th>ESTADO</th>
                            <th>KG</th>
                            <th>INCLUYE MODULACIÓN</th>
                            <th>ACCIONES</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cotiform as $cotizacion)
                        <tr>
                            <td>{{$cotizacion->id}}</td>
                            <td>{{$cotizacion->CardCode}}</td>
                            <td>{{$cotizacion->CardName}}</td>
                            <td>{{$cotizacion->Phone1}}</td>
                            <td>{{$cotizacion->Nombre_Obra}}</td>
                            <td>{{$cotizacion->Lugar_Obra}}</td>
                            <td>{{$cotizacion->Fecha_Recibido}}</td>
                            <td>{{$cotizacion->Fecha_Cotizada}}</td>
                          
                            <td>{{number_format($cotizacion->Valor_Adjudicado)}}</td>
                            <td>{{$cotizacion->Tipologia}}</td>
                            <td>
                                @if($cotizacion->Estado == 'Perdida')
                                <span class="btn btn-danger btn-sm btn-estado">{{$cotizacion->Estado}}</span>
                                @elseif($cotizacion->Estado == 'Seguimiento')
                                <span class="btn btn-warning btn-sm btn-estado">{{$cotizacion->Estado}}</span>
                                @elseif($cotizacion->Estado == 'Vendida')
                                <span class="btn btn-success btn-sm btn-estado">{{$cotizacion->Estado}}</span>
                                @elseif($cotizacion->Estado == 'Pendiente')
                                <span class="btn btn-danger btn-sm btn-estado">{{$cotizacion->Estado}}</span>
                                @endif
                            </td>
                            <td>{{$cotizacion->Kilogramos}}</td>
                            <td>{{$cotizacion->Incluye_Montaje}}</td>
                            <td>
                                <form action="{{ route('cotizaciones-formaletas.destroy', $cotizacion->id) }}"
                                    method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('put')
                                    <a class="btn btn-sm btn-success" href="{{route('cotizaciones-formaletas.edit',$cotizacion->id)}}">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-fw fa-trash"></i>
                                    </button>
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

@if (session('message'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'message',
    title: 'Éxito',
    text: '{{ session('
    message ') }}',
    confirmButtonText: 'OK',

});
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK',
        timerProgressBar: true // Mostrar barra de progreso del temporizador
    });
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: '¿Estás seguro que deseas eliminar el seguimiento?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar' // Cambio del texto del botón OK
    }).then((result) => {
        if (result.value) {
            this.submit();
        }
    })
});
</script>


@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            timerProgressBar: true // Mostrar barra de progreso del temporizador
        });
    </script>
@endif

@endsection