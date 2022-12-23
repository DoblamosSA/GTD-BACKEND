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
                            {{ __('Clientes Doblamos SAP') }}
                        </span>

                        <div class="float-right">
                            <a href="{{route('ClientesSap.create')}}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Crear Nuevo') }}
                            </a>

                        </div>


                    </div>


                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        <a class="btn btn-sm btn-primary" href="{{route('Clientes.RegistroClienteBD')}}"
                            target="_blank"><i class="fa-solid fa-hand"></i>
                            </i>Importar clientes SAP masivo </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#dialogo1">Importación Manual</button>
                    </div>


                </div>

                <br>

                @if (session()->has('success'))

                <div class="alert alert-info" role="alert">
                    {{session('success')}}
                </div>
                @endif



                <table class="table table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Cliente</th>
                            <th>Tipo Socio Negocio</th>
                            <th>Telefono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($clientesSAP as $cliente)

                        <td>{{$cliente['CardCode']}}</td>
                        <td>{{$cliente['CardName']}}</td>
                        <td>{{$cliente['CardType']}}</td>
                        <td>{{$cliente['Phone1']}}</td>


                        <td>
                            <form action="" method="POST">
                                @csrf
                                @method('put')
                                <span class="oi" data-glyph="print"></span>
                                <a class="btn btn-sm btn-primary btn-print" data-id="" href="" target="_blank"><i
                                        class="fa fa-print"></i> </a>
                                <a class="btn btn-sm btn-primary" href="" target="_blank"><i
                                        class="fas fa-file-pdf"></i> </a>
                                <a class="btn btn-sm btn-success" href=""><i
                                        class="RADOR' ? 'fa fa-fw fa-edit' : 'fa fa-fw fa-eye' }}"></i>
                                </a>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                <!-- Modal importacion manual clientes -->
                <div class="container">


                    <div class="modal fade" id="dialogo1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <!-- cabecera del diálogo -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Importación Manual SAP</h4>
                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                </div>

                                <!-- cuerpo del diálogo -->
                                <table class="table table-striped table-hover" class="table-dark">

                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <thead class="thead" class="table table-striped table-hover">


                                                <div class="d-md-flex justify-content-md-end">
                                                    <form action="{{route('ClientesSAP.ConsultaClientesManualSAP')}}"
                                                        method="GET">

                                                        <div class="btn-group">

                                                            <input type="text" name="Cedula" class="form-control">
                                                            <input type="submit" value="buscar"
                                                                class="btn btn-secondary">
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>

                                    </div>
                                    <br>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre Cliente</th>
                                        <th>Tipo Socio Negocio</th>
                                        <th>Telefono</th>
                                        <th>Acciones</th>
                                    </tr>
                                    <tbody>
                                        

                                        <td>L1007767612</td>
                                        <td>EDGAR STIBEN MADRID LONDOÑO</td>
                                        <td>LEAD</td>
                                        <td>3216499744</td>

                                        <td>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('put')
                                                <span class="oi" data-glyph="print"></span>
                                                <a class="btn btn-sm btn-primary" data-id="" href=""
                                                    target="_blank"><i></i>import </a>

                                            </form>
                                        </td>
                                        </tr>
                                    
                                    </tbody>
                                </table>
                                <br><br><br>
                                <!-- pie del diálogo -->

                            </div>

                        </div>
                    </div>
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
    'Seguimiento de la cotización eliminado Correctamente!',
    'success'
)
</script>
@endif

<script>
$('.formulario-eliminar').submit(function(e) {
    e.preventDefault();

    swal.fire({
        title: 'Estas seguro que deseas eliminar el cliente?',
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