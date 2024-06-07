
@extends('layouts.dashboard')

@section('template_title')
CNC
@endsection

@section('content')

<style>
.bodega-1 {
    color: red;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <br>
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" style="color: black; margin-left:40%;">
                            {{ __('CALCULADOR DE COSTOS DE NO CALIDAD') }}
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <h><b>Descripción del evento</b></h>
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" style="color: black;">
                                {{$costonocalidad->Descripcion}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>




            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" style="color: black; margin-left:40%; ">
                        </span>
                    </div>
                </div>

                <br>
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                    aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-dark">
                                {{ session('success') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="container">


                    <form method="post" action="{{route('Costo-No-Calidad.update',$costonocalidad->id)}}">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <br>
                                    <label for="calibres">Material implicito en el costo</label>
                                    <div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Lamina</span>
                                            <select name="lamina_id" id="lamina-select" class="form-control">
                                                <option value="">Seleccione una lámina</option>
                                                @foreach($laminas as $lamina)
                                                <option value="{{ $lamina->id }}">{{ $lamina->Codigo }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text">Calibre</span>
                                            <select name="calibre_id" id="calibre-select" class="form-control">
                                                <option value="">Seleccione un calibre</option>
                                                @foreach($calibres as $calibre)
                                                <option value="{{ $calibre->id }}">{{ $calibre->Calibre }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text">Cantidad de piezas</span>
                                            <input type="number" name="Cantidad_Piezas" class="form-control"
                                                placeholder="Cantidad de piezas">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Desarrollo</span>
                                            <input type="number" name="desarrollo" class="form-control" placeholder="">
                                            <span class="input-group-text">Longitud</span>
                                            <input type="number" name="longitud" class="form-control" placeholder="">
                                            <span class="input-group-text">Peso kg</span>
                                            <input type="number" name="Peso_kg" class="form-control" placeholder=""
                                                disabled>
                                            <span class="input-group-text">Precio Material</span>
                                            <input type="" name="Precio_Material" class="form-control" placeholder=""
                                                disabled>
                                            <span class="input-group-text">Total costo material</span>
                                            <input type="text" name="TotalCostoMaterial" id="total-costo-material"
                                                class="form-control" placeholder="" readonly>
                                            <button class="btn btn-primary add-linea" type="button">Agregar</button>

                                        </div>
                                    </div>
                                    <table id="lineas-agregadas" class="table table-bordered ">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Lamina</th>
                                                <th>Calibre</th>
                                                <th>Cantidad de piezas</th>
                                                <th>Desarrollo</th>
                                                <th>Longitud</th>
                                                <th>Peso</th>
                                                <th>Precio Material</th>
                                                <th>Total Costo Material</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Suma Material Implicito</span>
                                        <input class="form-control thead-dark" type="text"
                                            id="input-total-costo-material" disabled>
                                        <input type="hidden" id="input-total-costo-material-numeric">
                                        <!-- Nueva línea -->

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="calibres">Recursos:</label>
                            <div id="recursos">
                                <div class="input-group mb-3">
                                    <select name="recurso[]" id="recurso-select" class="form-control"
                                        style="width: 300px;">
                                        <option value="">Seleccione un recurso</option>
                                        @foreach($recursos as $recurso)
                                        <option value="{{ $recurso->id }}" data-costo="{{ $recurso->Cost1 }}">

                                            {{ $recurso->Name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="cantidad" class="form-control flex-fill cantidad"
                                        placeholder="Cantidad">
                                    <input type="number" name="horas" class="form-control horas" placeholder="Horas"
                                        >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="Cost1" class="form-control flex-fill Cost1"
                                        placeholder="Costo del recurso" readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Unidad de medida</span>
                                    </div>
                                    <input type="text" class="form-control unit-of-measure"
                                        placeholder="Unidad de medida" readonly>

                                    <input type="text" class="form-control SumaRecursoNivelLinea" readonly disabled>

                                    <div class="input-group-append">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary add-recursos" type="button">Agregar</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Suma total de recursos</span>
                                <input type="hidden" id="total-recursos-form">
                                <input type="text" class="form-control" id="total-recursos-formatted"
                                    name="total-recursos" placeholder="" disabled>

                            </div>
                        </div>


                        <div id="formulario" class="form-group">
                            <label for="calibres">Estandar:</label>
                            <div class="input-group mb-3">
                                <select class="form-control  select2 " id="materialestandarselect">
                                    <option value="">Seleccione el material</option>
                                    @foreach($materiales as $materialEstandar )
                                    <option value="{{$materialEstandar->id}}">
                                        {{$materialEstandar->ItemCode}}- {{$materialEstandar->ItemName}}
                                    </option>
                                    @endforeach
                                </select>
                                </select>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Cantidad</span>
                                </div>
                                <input type="number" class="form-control" id="cantidad-Material-Estandar">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Costo</span>
                                </div>
                                <input type="hidden" class="form-control" id="CostoMaterialEstandar" disabled>
                                <div class="input-group-append">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary add-material-estandar"
                                            type="button">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="tabla-materiales" class="table table-bordered ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Material ID</th>
                                    <th>Cantidad</th>
                                    <th>Costo</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas de la tabla se agregarán aquí -->
                            </tbody>
                        </table>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Suma material Estandas</span>
                            <input class="form-control thead-dark" type="text" id="sumatotalmaterialestandar-visible"
                                disabled>
                            <input type="hidden" id="sumatotalmaterialestandar">
                        </div>




                        <label for="calibres">Otros costos:</label>
                        <div class="input-group mb-3">

                            <input type="number" class="form-control" id="otros-costos"></input>

                        </div>
                        <div>
                            <label for="calibres">Transporte Logistica:</label>
                            <div class="input-group mb-3">
                                <select name="transporte-logistica" id="transporte-logistica" class="form-control"
                                    style="width: 300px;">
                                    <option value="">Seleccione un transporte</option>
                                    @foreach($transporte as $trans)
                                    <option value="{{ $trans->Codigo }}">{{ $trans->Descripcion }}</option>
                                    @endforeach
                                    <option value="otro">Otro</option>
                                </select>
                                <input type="hidden" id="valor-transporte-form">
                                <input type="text" name="valor-transporte" id="valor-transporte-formatted"
                                    class="form-control valor-transporte" placeholder="Precio del transporte" readonly>

                                <input type="text" name="otro-valor-transporte" id="otro-valor-transporte"
                                    class="form-control otro-valor-transporte"
                                    placeholder="Ingrese otro valor de transporte" style="display: none;">
                            </div>
                        </div>





                        <div class="form-group">
                            <label for="calibres"> Recuperado en chatarra:</label>
                            <div class="input-group mb-3">
                                <select name="recurso" id="recursos-recuperado" class="form-control recuperado">
                                    <option value="">Seleccione el recurso chatarra</option>
                                    @foreach($recursos as $recurso)
                                    <option value="{{ $recurso->id }}" data-costo="{{ $recurso->Cost1 }}"
                                        data-unit-of-measure="{{ $recurso->UnitOfMeasure }}">
                                        {{ $recurso->Name }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="number" name="cantidad" class="form-control flex-fill"
                                    placeholder="Cantidad" id="cantidad">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="hidden" name="precio-chatarra" id="precio-chatarra-form">
                                <input type="text" class="form-control flex-fill" placeholder="Precio Chatarra"
                                    id="precio-chatarra-formatted" readonly>

                            </div>
                            <div class="input-group-prepend">
                                <span class="input-group-text">Total recuperado chatarra</span>
                                <input type="hidden" name="total-recuperado-chatarra"
                                    id="total-recuperado-chatarra-form">
                                <input type="text" class="form-control" id="total-recuperado-chatarra-formatted"
                                    disabled>


                            </div>

                        </div>

                        <!-- <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <br>
                                    <label for="calibres">Recuperado materia prima</label>
                                    <div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Lamina</span>
                                            <select name="materialrecuperadomateriaprima"
                                                id="materialrecuperadomateriaprima" class="form-control">
                                                <option value="">Seleccione una lámina</option>
                                                @foreach($laminas as $lamina)
                                                <option value="{{ $lamina->id }}">{{ $lamina->Codigo }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text">Calibre</span>
                                            <select name="calibre-select-mpmaterialrecuperado"
                                                id="calibre-select-mpmaterialrecuperado" class="form-control">
                                                <option value="">Seleccione un calibre</option>
                                                @foreach($calibres as $calibre)
                                                <option value="{{ $calibre->id }}">{{ $calibre->Calibre }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text">Cantidad piezas</span>
                                            <input type="number" name="cantidadpiezasmprecuperado" class="form-control"
                                                placeholder="Cantidad piezas recuperadas"
                                                id="cantidadpiezasmprecuperado">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Desarrollo</span>
                                            <input type="number" name="desarrollo-recuperadomp" class="form-control"
                                                placeholder="">
                                            <span class="input-group-text">Longitud</span>
                                            <input type="number" name="longitud-recuperadomp" class="form-control"
                                                placeholder="">
                                            <span class="input-group-text">Peso kg</span>
                                            <input type="number" name="Peso_kg-recuperadomp" class="form-control"
                                                placeholder="" disabled>
                                            <span class="input-group-text">Precio Material</span>
                                            <input type="" name="Precio_Material-recuperadomp" class="form-control"
                                                placeholder="" disabled>
                                            <span class="input-group-text">Total costo material</span>
                                            <input type="text" name="TotalCostoMaterialrecuperadomp"
                                                id="total-costo-material-recuperado" class="form-control" placeholder=""
                                                readonly>
                                            <button class="btn btn-primary add-linea-materialrecuperadomp"
                                                type="button">Agregar</button>
                                        </div>
                                    </div>
                                    <table id="lineas-agregadas-matrecupemp" class="table table-bordered">
                                        <thead class="thead-dark">
                                            <th>Lamina</th>
                                            <th>Calibre</th>
                                            <th>Cantidad piezas recuperadas</th>
                                            <th>Desarrollo</th>
                                            <th>Longitud</th>
                                            <th>Peso</th>
                                            <th>Precio Material</th>
                                            <th>Total Costo Material recuperado</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Total recuperado chatarra materia
                                            prima</span>
                                        <input type="" class="form-control" placeholder=""
                                            id="total-recuperado-chatarramp" readonly disabled>
                                        <input type="hidden" id="total-recuperado-chatarramp-numeric">
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <br>
                                    <label for="calibres">Material recuperado materia prima </label>
                                    <div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Lamina</span>
                                            <select name="lamina_id" id="lamina-selectmp" class="form-control">
                                                <option value="">Seleccione una lámina</option>
                                                @foreach($laminas as $lamina)
                                                <option value="{{ $lamina->id }}">{{ $lamina->Codigo }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text">Calibre</span>
                                            <select name="calibre_id" id="calibre-selectmp" class="form-control">
                                                <option value="">Seleccione un calibre</option>
                                                @foreach($calibres as $calibre)
                                                <option value="{{ $calibre->id }}">{{ $calibre->Calibre }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text">Cantidad de piezas</span>
                                            <input type="number" name="Cantidad_Piezasmp" class="form-control"
                                                placeholder="Cantidad de piezas">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Desarrollo</span>
                                            <input type="number" name="desarrollomp" class="form-control" placeholder="">
                                            <span class="input-group-text">Longitud</span>
                                            <input type="number" name="longitudmp" class="form-control" placeholder="">
                                            <span class="input-group-text">Peso kg</span>
                                            <input type="number" name="Peso_kgmp" class="form-control" placeholder=""
                                                disabled>
                                            <span class="input-group-text">Precio Material</span>
                                            <input type="" name="Precio_Materialmp" class="form-control" placeholder=""
                                                disabled>
                                            <span class="input-group-text">Total costo material</span>
                                            <input type="text" name="TotalCostoMaterialmp" id="total-costo-materialmp"
                                                class="form-control" placeholder="" readonly>
                                            <button class="btn btn-primary add-lineamp" type="button">Agregar</button>

                                        </div>
                                    </div>
                                    <table id="lineas-agregadasmp" class="table table-bordered ">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Lamina</th>
                                                <th>Calibre</th>
                                                <th>Cantidad de piezas</th>
                                                <th>Desarrollo</th>
                                                <th>Longitud</th>
                                                <th>Peso</th>
                                                <th>Precio Material</th>
                                                <th>Total Costo Material</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Suma Material Implicito</span>
                                        <input class="form-control thead-dark" type="text"
                                            id="input-total-costo-materialmp" disabled>
                                        <input type="hidden" id="input-total-costo-material-numericmp">
                                        <!-- Nueva línea -->

                                    </div>
                                </div>
                            </div>
                        </div>


                        <br>
						   <div class="input-group mb-3">
                            <span class="input-group-text">Descripcion de la correcion</span>
                            <textarea class="form-control " placeholder="" name="CorreccionEvento" required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Tipo Accion</span>
                            <select name="TipoAccion" class="form-control" required>
                                <option value="">Selecciona una opción</option>
                                <option value="Mejora">Mejora</option>
                                <option value="Correctiva">Correctiva</option>
                                <option value="Preventiva">Preventiva</option>
                            </select>
                        </div>
                        <input type="hidden" value="Costeado" name="EstadoCNC" readonly>

                       <div class="input-group mb-3">
                            <span class="input-group-text">Costo CNC </span>
                            <input type="text" name="" id="CostoCNC-formateado" class="form-control" placeholder="" disabled>
                            <input type="hidden" name="CostoCNC" id="CostoCNC" class="form-control">

                            
                            <span class="input-group-text">Valor recuperado </span>
                            <input type="text" name="" id="SaldoRecuperado-formateado" class="form-control" placeholder="" disabled
                                >
                            <input type="hidden" name="SaldoRecuperado" id="SaldoRecuperadoHidden">


                            <span class="input-group-text">Costo Final</span>
                            <input type="hidden" name="SaldoFinalCNC" id="SaldoFinalCNC" class="form-control"
                                placeholder="" readonly style="background-color: green; color: white;">
                                <input type="text" name="" id="SaldoFinalCNC-Recuperado" class="form-control"
                                placeholder="" readonly style="background-color: green; color: white;">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Guardar Costeo</button>
                </div>



                </form>
               

            </div>


            <BR>
        </div>

    </div>

</div>
</div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('js/CalculadoraCNC/calculadora.js') }}"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

@if (session('success'))
<script>
$(document).ready(function() {
    $('#successModal').modal('show');
});
</script>
@endif




@endsection