@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection

@section('content')
<br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{route('cotizaciones-formaleta.update',$cotizacionesformaleta->id)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-4">
                                <label for="campo1">Nombre Obra</label>
                                <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra"
                                    value="{{ $cotizacionesformaleta->Nombre_Obra }}">

                            </div>
                            <div class="col-4">
                                <label for="Fecha Recibido">Lugar Obra</label>
                                <input type="text" class="form-control" name="Lugar_Obra"
                                    value="{{$cotizacionesformaleta->Lugar_Obra}}">
                            </div>
                            <div class="col-4">
                                <label for="Fecha Recibido">Fecha Recibido</label>
                                <input type="date" class="form-control" name="Fecha_Recibido"
                                    value="{{$cotizacionesformaleta->Fecha_Recibido}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo4">Fecha Cotizada</label>
                                <input type="date" class="form-control" name="Fecha_Cotizada"
                                    value="{{$cotizacionesformaleta->Fecha_Cotizada}}">
                            </div>
                            <div class="col-4">
                                <label for="campo5">Valor Antes Iva</label>
                                <input type="foat" class="form-control" placeholder="Valor antes iva "
                                    name="Valor_Antes_Iva" value="{{$cotizacionesformaleta->Valor_Antes_Iva}}">
                            </div>
                            <div class="col-4">
                                <label for="Estado">Estado</label>
                                <select name="Estado" class="form-control" placeholder="Estado" id="Estado">
                                    <option class="form-control">{{$cotizacionesformaleta->Estado}}</option>
                                    <option class="form-control" value="Perdida">Perdida</option>
                                    <option class="form-control" value="Seguimiento">Seguimiento</option>
                                    <option class="form-control" value="Vendida">Vendida</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo7">Tipologia</label>
                                <select name="Tipologia" class="form-control" placeholder="Tipologia">
                                    <option class="form-control">{{$cotizacionesformaleta->Tipologia}}</option>
                                    <option class="form-control" value="Tablero Estándar">Tablero Estándar</option>
                                    <option class="form-control" value="Tablero Circular">Tablero Circular</option>
                                    <option class="form-control" value="Tablero modular">Tablero modular</option>
                                    <option class="form-control" value="Rinconeras">Rinconeras</option>
                                    <option class="form-control" value="Tapa muros">Tapa muros</option>
                                    <option class="form-control" value="Accesorios">Accesorios</option>
                                    <option class="form-control" value="New jersey">New jersey</option>
                                    <option class="form-control" value="Bordillo">Bordillo</option>
                                    <option class="form-control" value="Cohete">Cohete</option>
                                    <option class="form-control" value="Manhole">Manhole</option>
                                    <option class="form-control" value="juego de columnas">juego de columnas</option>
                                    <option class="form-control" value="Formaletas para muros">Formaletas para muros</option>
                                    <option class="form-control" value="Formaletas para losa">Formaletas para losa</option>
                                    <option class="form-control" value="Formaletas para vaciado de losa">Formaletas para vaciado de losa</option>
                                    <option class="form-control" value="Equipo de seguridad exterior de vaciados">Equipo de seguridad exterior de vaciados</option>
                                    <option class="form-control" value="Equipo de vaciado de muros">Equipo de vaciado de muros</option>
                                    <option class="form-control" value="Plataforma de vaciado de obra">Plataforma de vaciado de obra</option>
                                    <option class="form-control" value="Escaleras de acceso a vaciado">Escaleras de acceso a vaciado</option>
                                    <option class="form-control" value="Proyectos especiales">Proyectos especiales</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="campo8">Valor Adjudicado</label>
                                <input type="number" class="form-control" name="Valor_Adjudicado" id="Valor_Adjudicado"
                                    value="{{$cotizacionesformaleta->Valor_Adjudicado}}">
                            </div>
                            <div class="col-4">
                                <label for="campo9">Valor Kilogramo</label>
                                <input type="number" class="form-control" placeholder=" " name="Valor_Kilogramo"
                                    value="{{$cotizacionesformaleta->Valor_Kilogramo}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo1">Metros cuadrados</label>
                                <input type="number" class="form-control" placeholder="" name="Metros_Cuadrados"
                                    value="{{$cotizacionesformaleta->Metros_Cuadrados}}">
                            </div>
                            <div class="col-4">
                                <label for="campo1">Kilogramos</label>
                                <input type="number" class="form-control" placeholder="" name="Kilogramos"
                                    value="{{$cotizacionesformaleta->Kilogramos}}">
                            </div>
                            <div class="col-4">
                                <label for="Asesor">Asesor</label>
                                <select name="Asesor_id" class="form-control" id="Asesor_id">
                                    @foreach ($asesores as $asesor)
                                    <option value="{{ $asesor->id }}"
                                        {{ $cotizacionesformaleta->Asesor_id == $asesor->id ? 'selected' : '' }}>
                                        {{ $asesor->Nombre_Asesor }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo1">Origen</label>
                                <select name="Origen" class="form-control" id="origen" onchange="checkOrigen(this)">
                                    <option >{{$cotizacionesformaleta->Origen }}</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Pagina web">Página web</option>
                                    <option value="Asesor">Asesor</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div id="modal-otro" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ingresar otro valor</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" id="input-origen-otro" class="form-control"
                                                placeholder="Ingresar otro valor">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                            <button id="btn-guardar-modal" type="button" class="btn btn-primary"
                                                data-dismiss="modal">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="Fecha Recibido">Incluye Modulación</label>
                                <select name="Incluye_Montaje" class="form-control" placeholder="Incluye Montaje">
                                    <option class="form-control">{{$cotizacionesformaleta->Incluye_Montaje}}</option>
                                    <option class="form-control" value="Si Incluye">Si Incluye</option>
                                    <option class="form-control" value="No Incluye">No Incluye</option>
                                </select>
                            </div>
                            <input type="hidden" name="clientes_id" id="clientes_id" value="{{$cotizacionesformaleta->clientes_id}}">
                            <div class="col-4">
                                <label for="Pais">pais</label>
                                <select name="pais_id" class="form-control" id="pais_id" required>
                                    @foreach($pais as $paisItem)
                                    <option value="{{ $paisItem->id }}"
                                        {{ $cotizacionesformaleta->pais_id == $paisItem->id ? 'selected' : '' }}>
                                        {{ $paisItem->countryName }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-4">
                                <label for="Departamento">Departamento</label>
                                <select name="Departamento" class="form-control" id="Departamento">
                                    <option>{{$cotizacionesformaleta->Departamento }} </option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Amazonas">Amazonas</option>
                                    <option value="Antioquia">Antioquia</option>
                                    <option value="Arauca">Arauca</option>
                                    <option value="Atlántico">Atlántico</option>
                                    <option value="Bolívar">Bolívar</option>
                                    <option value="Boyacá">Boyacá</option>
                                    <option value="Caldas">Caldas</option>
                                    <option value="Caquetá">Caquetá</option>
                                    <option value="Casanare">Casanare</option>
                                    <option value="Cauca">Cauca</option>
                                    <option value="Cesar">Cesar</option>
                                    <option value="Chocó">Chocó</option>
                                    <option value="Córdoba">Córdoba</option>
                                    <option value="Cundinamarca">Cundinamarca</option>
                                    <option value="Guainía">Guainía</option>
                                    <option value="Guaviare">Guaviare</option>
                                    <option value="Huila">Huila</option>
                                    <option value="La Guajira">La Guajira</option>
                                    <option value="Magdalena">Magdalena</option>
                                    <option value="Meta">Meta</option>
                                    <option value="Nariño">Nariño</option>
                                    <option value="Norte de Santander">Norte de Santander</option>
                                    <option value="Putumayo">Putumayo</option>
                                    <option value="Quindío">Quindío</option>
                                    <option value="Risaralda">Risaralda</option>
                                    <option value="San Andrés y Providencia">San Andrés y Providencia</option>
                                    <option value="Santander">Santander</option>
                                    <option value="Sucre"> Sucre</option>
                                    <option value="Tolima">Tolima</option>
                                    <option value="Valle del Cauca">Valle del Cauca</option>
                                    <option value="Vaupés">Vaupés</option>
                                    <option value="Vichada">Vichada</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="Pais">Fecha de venta</label>
                                <input type="date" name="Fecha_Venta" class="form-control"
                                    value="{{$cotizacionesformaleta->Fecha_Venta}}"></input>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Guardar seguimiento') }}
                            </button>
                        </div>
                    </form>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{asset('js/Cotizaciones_Formaletas/cotizacionesFormaletas.js')}}"></script>



<script>
// JavaScript
function checkOrigen(selectElement) {
    var selectedValue = selectElement.value;
    if (selectedValue === "Otro") {
        $('#modal-otro').modal('show'); // Abre el modal
    }
}

$('#btn-guardar-modal').click(function() {
    var otroValor = $('#input-origen-otro').val();

    if (otroValor.trim() !== "") {
        var selectOrigen = $('select[name="Origen"]');
        var option = '<option value="' + otroValor + '">' + otroValor + '</option>';
        selectOrigen.append(option);
        selectOrigen.val(otroValor);
    }
});
</script>
// Vista
@if ($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    html: '@foreach ($errors->all() as $error){{ $error }}<br>@endforeach',
    confirmButtonText: 'OK',
    timerProgressBar: true // Mostrar barra de progreso del temporizador
});
</script>
@endif

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




@if (session('successSAP'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('successSAP') }}',
            confirmButtonText: 'OK',
            timerProgressBar: true
        });
    </script>
@endif

@if (session()->has('msjSAP'))
    @if (session('executeScript'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Mensaje',
                text: '{{ session('msjSAP') }}',
                confirmButtonText: 'OK',
                timer: 4000,
                timerProgressBar: true
            });
        </script>
    @endif
@endif
@if (session('errorgeneral'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '{{ session('
    errorgeneral ') }}',
    confirmButtonText: 'OK',
    timerProgressBar: true // Mostrar barra de progreso del temporizador
});
</script>
@endif

@endsection