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
                            {{ __('Historico de cotizaciones') }}
                        </span>

                    </div>

                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">


                        <form action="{{url('vortexDoblamos/cotizacionesHistoricas')}}" method="POST"
                            enctype="multipart/form-data">
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

                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th>No. OBRA</th>
                            <th>EMPRESA O CLIENTE</th>
                            <th>FECHA DE RECIBIDO</th>
                            <th>NOMBRE DE LA OBRA</th>
                            <th>DESCRIPCIÓN</th>
                            <th>ESTADO</th>
                            <th>"FECHA COTIZADA"</th>
                            <th>VALOR ANTES IVA</th>
                            <th>CONTACTO</th>
                            <th>AREA (m2)</th>
                            <th>$/m2</th>
                            <th>Incluye Montaje</th>
                            <th>Origen</th>
                        </tr>



                    </thead>
                    <tbody>
                        @foreach($historialCotizaciones as $historial)
                        <tr>



                            <td>{{$historial->Numero_Obra}}</td>
                            <td>{{$historial->Empresa_Cliente}}</td>
                            <td>{{$historial->Fecha_Recibido}}</td>
                            <td>{{$historial->Nombre_Obra}}</td>
                            <td>{{$historial->Descripcion}}</td>
                            <td>{{$historial->Estado}}</td>
                            <td>{{$historial->Fecha_Cotizada}}</td>
                            <td>{{$historial->Valor_Antes_Iva}}</td>
                            <td>{{$historial->Contacto}}</td>
                            <td>{{$historial->Area_M2}}</td>
                            <td>{{$historial->M2}}</td>
                            <td>{{$historial->Incluye_Montaje}}</td>
                            <td>{{$historial->Origen}}</td>
                      

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
