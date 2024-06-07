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


                            @if(auth()->user()->can('Crear_Clientes_SAP'))
                            <a href="{{route('ClientesSap.create')}}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Crear Nuevo') }}
                            </a>
                            @endif

                        </div>


                    </div>


                </div>

                <br>

                <div class="d-md-flex justify-content-md-end">
                    <div class="col">

                        @if(auth()->user()->can('Clientes_Importar_SAP'))
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="crearclientesdb()"><i class="fa-solid fa-hand"></i> </i>Importar clientes SAP masivo </button>

                        @endif


                        @if(auth()->user()->can('Importacion_clientes_Manua'))
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dialogo1">Importación Manual</button>
                        @endif

                        @if(auth()->user()->can('Importacion_Empleados_SAP'))
                        <a href="{{url('Empleados-SAP')}}" class="btn btn-secondary"><i></i> Importar Empleados SAP

                        </a>
                        @endif

                        <br><br>

                        <ul class="nav nav-tabs">

                            <form action="{{url('clientes/ferias')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="excel_file">Importar clientes Ferias Archivo de Excel:</label>
                                    <input type="file" name="excel_file" id="excel_file" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Cargar</button>
                            </form>

                        </ul>
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

                @if(auth()->user()->can('Clientes_Buscar_clientes'))
                <nav class="navbar navbar-light">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <form class="form-inline" method="GET" action="{{ route('ClientesSap.index') }}">
                                <input type="text" class="form-control mr-sm-2" name="query" aria-label="Search" placeholder="Buscar..." value="{{ $query ?? '' }}">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                            </form>
                        </li>
                    </ul>
                </nav>
                @endif
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Cliente</th>

                            <th>Telefono</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($clientesSAP as $cliente)

                        <td>{{$cliente['CardCode']}}</td>
                        <td>{{$cliente['CardName']}}</td>
                        <td>{{$cliente['Phone1']}}</td>



                        </tr>
                        @endforeach
                    </tbody>

                </table>


                <h1></h1>
                <table class="table table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>EMPRESA</th>
                            <th>CONTACTO</th>
                            <th>APELLIDO</th>
                            <th>PAIS</th>
                            <th>REGION</th>
                            <th>TELEFONO</th>
                            <th>CORREO</th>
                            <th>VORTEX</th>
                            <th>FORMALETAS</th>
                            <th>ESTRUCTURAS</th>
                            <th>SERVICIOS</th>
                            <th>VENTA ACERO</th>
                            <th>OBSERVACIONES</th>
                            <th>TIPO BD</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clientes_ferias as $cliente_feria)
                        <tr>
                            <td>{{ $cliente_feria->empresa ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->contacto ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->apellido ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->pais ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->region ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->telefono ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->correo ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->vortex ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->formaletas ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->estructuras ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->servicios ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->venta_acero ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->observaciones ?: 'Sin información' }}</td>
                            <td>{{ $cliente_feria->tipo_bd ?: 'Sin información' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                </table>
                <div class="d-flex justify-content-end">
                    {!! $clientesSAP->links() !!}
                </div>



            </div>



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

                                                <form action="" method="post">
                                                    @csrf
                                                    <label for="cedula">Cédula del cliente:</label><br>
                                                    <input type="text" id="cedula" name="Cedula"><br>
                                                    <button type="submit">Buscar</button>
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


                                    <td></td>
                                    <td></td>

                                    <td>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('put')
                                            <span class="oi" data-glyph="print"></span>
                                            <a class="btn btn-sm btn-primary" data-id="" href="" target="_blank"><i></i>import </a>

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


<script>
    function crearclientesdb() {
        window.location = 'Clientes/sql';
    }
</script>
<script>

</script>
@endsection