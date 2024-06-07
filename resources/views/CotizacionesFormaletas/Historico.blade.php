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

/* Estilos para que la tabla sea responsive */
div.dataTables_wrapper div.dataTables_length select,
div.dataTables_wrapper div.dataTables_filter input {
    width: auto;
}

div.dataTables_wrapper.dataTables_scroll {
    clear: both;
}

table.dataTable tbody th,
table.dataTable tbody td {
    white-space: nowrap;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Historico de cotizaciones formaletas') }}
                        </span>
                    </div>
                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">
                        <form action="{{url('Historico-formaletas')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="excel_file">Archivo de Excel:</label>
                                <input type="file" name="excel_file" id="excel_file" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Cargar</button>
                        </form>
                    </div>
                </div>
                <br>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatableinfo">
                        <thead class="table-dark">
                            <tr>
                            <th>AREA</th>
                            <th>NUMERO OBRA</th>
                            <th>EMPRESA</th>
                            
                            <th>FECHA RECIBIDO</th>
                            <th>ESTADO</th>
                            <th>ASESOR</th>
                            <th>OBSERVACIONES</th>
                            <th>SEGUIMIENTO</th>
                            <th>REQUIERE ING</th>
                            <th>VALOR COTIZADO</th>
                            <th>VALOR ADJUDICADO</th>
                            <th>NUMERO ORDEN</th>
                            <th>NUMERO FACTURA</th>
                            <th>FECHA FACTURA</th>
                            <th>PESO KG</th>
                            <th>AREA M2</th>
                            <th>/KG</th>
                            <th>CANTIDAD ELEMENTOS</th>
                                <!-- Resto de las columnas -->
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach($hisformaleta as $historico)
                            <tr>
                            <td>{{$historico->area}}</td>
                            <td>{{$historico->numero_obra}}</td>
                            <td>{{$historico->empresa}}</td>
                            <td>{{$historico->fecha_recibido}}</td>
                            <td>{{$historico->estado}}</td>
                            <td>{{$historico->asesor}}</td>
                            <td>{{$historico->observaciones}}</td>
                            <td>{{$historico->seguimiento}}</td>
                            <td>{{$historico->requiereing}}</td>
                            <td>{{$historico->valorcotizado}}</td>
                            <td>{{$historico->valoradjudicado}}</td>
                            <td>{{$historico->numeroorden}}</td>
                            <td>{{$historico->numerofactura}}</td>
                            <td>{{$historico->fechafactura}}</td>
                            <td>{{$historico->pesokg}}</td>
                            <td>{{$historico->aream2}}</td>
                            <td>{{$historico->{'/kg'} }}</td>
                            <td>{{$historico->cantidadelementos}}</td>
                         
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

@endsection

