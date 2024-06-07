@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/MRP/mrp.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ __('Clientes Doblamos SAP') }}</h5>
                        <div class="ml-auto text-right">
                            <form id="buscarClienteForm" class="form-inline mb-3">
                                <div class="form-group mr-2">
                                    <input type="text" class="form-control" id="cliente" name="cliente" placeholder="NIT CLIENTE">
                                </div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRegistroClienteSAP">
                            Crear cliente
                        </button>
                    </div>

                </div>
                <br>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaResultados" class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se agregarán las filas de los resultados -->
                            </tbody>
                        </table>
                    </div>
                    @if (session()->has('msjSAP'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error:</strong> {{ session('msjSAP') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="modal fade" id="modalRegistroClienteSAP" tabindex="-1" role="dialog" aria-labelledby="modalRegistroClienteSAPLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalRegistroClienteSAPLabel">Registro Cliente SAP</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="registroClienteForm" action="{{ route('ClientesSAP.RegistroClienteSAP') }}" method="POST" class="guardadosap">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Cedula o nit cliente" name="CardCode">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Nombres Cliente" name="CardName" value="{{ old('CardName') }}">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <input type="text" class="form-control" placeholder="Rut Cliente" name="FederalTaxID">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <input type="text" class="form-control" placeholder="Email" name="Address">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <input type="number" class="form-control" placeholder="Telefono" name="Phone1">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <input type="text" class="form-control" placeholder="Ciudad" name="City">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <input type="text" class="form-control" placeholder="Pais" name="Country" value="CO" disabled>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <input type="text" class="form-control" placeholder="correo facturacion eletronica" name="EmailAddress">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                        </div>
                                    </form>
                                    <div id="loading-overlays" class="loading-overlay">
                                        <div class="loading-spinner">
                                            <i class="fas fa-spinner fa-pulse"></i>
                                            <span>Creando cliente en SAP...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('vortexDoblamos.store')}}" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-4">
                                <label for="campo1">Nombre Obra</label>
                                <input type="text" class="form-control" placeholder="Nombre Obra" name="Nombre_Obra" value="{{old('Nombre_Obra')}}">
                            </div>
                            <div class="col-4">
                                <label for="Fecha Recibido">Lugar Obra</label>
                                <input type="text" class="form-control" name="Lugar_Obra" value="{{old('Lugar_Obra')}}">
                            </div>

                            <div class="col-4">
                                <label for="Fecha Recibido">Fecha Recibido</label>
                                <input type="date" class="form-control" name="Fecha_Recibido" value="{{old('Fecha_Recibido')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo4">Fecha Cotizada</label>
                                <input type="date" class="form-control" name="Fecha_Cotizada" value="{{old('Fecha_Cotizada')}}">
                            </div>
                            <div class="col-4">
                                <label for="campo5">Valor Antes Iva</label>
                                <input type="foat" class="form-control" placeholder="Valor antes iva " name="Valor_Antes_Iva" value="{{old('Valor_Antes_Iva')}}">
                            </div>
                            <div class="col-4">
                                <label for="Estado">Estado</label>
                                <select name="Estado" class="form-control" placeholder="Estado" id="Estado" onchange="mostrarModalSeguimiento()">
                                    <option class="form-control">{{old('Estado')}}</option>
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
                                    <option class="form-control">{{old('Tipologia')}}</option>
                                    <option class="form-control" value="Fachadas 3D">Fachadas 3D</option>
                                    <option class="form-control" value="Fachadas 2D">Fachadas 2D</option>
                                    <option class="form-control" value="Cerramientos">Cerramientos</option>
                                    <option class="form-control" value="Puertas">Puertas</option>
                                    <option class="form-control" value="Lamina Perforada">Lamina Perforada</option>
                                    <option class="form-control" value="Paneles">Paneles</option>
                                    <option class="form-control" value="Cielos">Cielos</option>
                                    < <option class="form-control" value="Louvers">Louvers</option>
                                        <option class="form-control" value="Corta Soles">Corta Soles</option>
                                        <option class="form-control" value="Avisos">Avisos</option>
                                        <option class="form-control" value="Pasamanos">Pasamanos</option>
                                        <option class="form-control" value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="campo8">Valor Adjudicado</label>
                                <input type="float" class="form-control" name="Valor_Adjudicado" id="Valor_Adjudicado" value="{{old('Valor_Adjudicado')}}" required>
                            </div>
                            <div class="col-4">
                                <label for="campo9">$M2</label>
                                <input type="text" class="form-control" placeholder="$m2 " name="m2" value="{{old('m2')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="campo1">Metros cuadrados</label>
                                <input type="number" class="form-control" placeholder="" name="Metros_Cuadrados" value="{{old('Metros_Cuadrados')}}">
                            </div>
                            <div class="col-4">
                                <label for="Fecha Recibido">#Obra</label>
                                <input type="text" class="form-control" name="Total_Asesor" value="{{old('Total_Asesor')}}">
                            </div>
                            <div class="col-4">
                                <label for="Fecha Recibido">Asesor</label>
                                <select name="Asesor_id" class="form-control" id="Asesor_id">
                                    @foreach ($Asesor as $row)
                                    <option value="{{ $row->id }}">
                                        {{ $row->id }}. {{ $row->Nombre_Asesor }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <label for="campo1">Origen</label>
                                 <select name="Origen" class="form-control" id="origen" onchange="checkOrigen(this)">
                                    <option value="{{ old('Origen') }}">{{ old('Origen') }}</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Pagina web">Página web</option>
                                    <option value="Valla">Valla</option>
                                    <option value="Referido">Referido</option>
                                    <option value="Cliente actual">Cliente actual</option>
                                    <option value="Distribuidor">Distribuidor</option>
                                    <option value="Ideo">Ideo</option>
                                    <option value="Asesor">Asesor</option>
									 <option value="Doblacero">Doblacero</option>
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
                                            <input type="text" id="input-origen-otro" class="form-control" placeholder="Ingresar otro valor">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button id="btn-guardar-modal" type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </select>

                            <div class="col-4">
                                <label for="Fecha Recibido">Incluye Montaje</label>
                                <select name="Incluye_Montaje" class="form-control" placeholder="Incluye Montaje">
                                    <option class="form-control">{{old('Incluye_Montaje')}}</option>
                                    <option class="form-control" value="Si Incluye">Si Incluye</option>
                                    <option class="form-control" value="No Incluye">No Incluye</option>

                                </select>
                            </div>

                            <input type="hidden" name="clientes_id" id="clientes_id" value="">
                            <div class="col-4">
                                <label for="Pais">pais</label>
                                <select name="Pais" class="form-control" id="" required>
                                    @foreach ($pais as $pais)
                                    <option value="{{ $pais->id }}">
                                        {{ $pais->countryName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="Pais">Fecha de venta</label>
                                <input type="date" name="Fecha_Venta" class="form-control"></input>
                            </div>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
        text: '{{ session('
        success ') }}',
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
        text: '{{ session('
        successSAP ') }}',
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
        text: '{{ session('
        msjSAP ') }}',
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

<script>
    $(document).ready(function() {
        $('#registroClienteForm').submit(function(e) {
            e.preventDefault();

            // Mostrar el spinner
            $('#loading-overlays').show();

            // Realizar la solicitud AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json', // Especificar el tipo de datos esperado en la respuesta
                success: function(response) {
                    // Ocultar el spinner después de completar la solicitud
                    $('#loading-overlays').hide();

                    // Manejar la respuesta del servidor
                    if (response.success) {
                        // Muestra SweetAlert2 con el mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Cliente creado exitosamente',
                        }).then(function() {
                            // Recarga la página después de cerrar la alerta
                            location.reload();
                        });
                    } else {
                        // Muestra SweetAlert2 con el mensaje de error y detalles si disponibles
                        var errorMessage = 'Error en la solicitud a la API';

                        if (response.error) {
                            errorMessage = response.error;
                        } else if (response.details) {
                            // Si hay detalles, muestra los mensajes de detalle
                            errorMessage += '<br><strong>Detalles:</strong> ' + response.details;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessage,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Ocultar el spinner en caso de error
                    $('#loading-overlays').hide();

                    // Muestra SweetAlert2 con el mensaje de error y detalles si disponibles
                    var errorMessage = 'Error en la solicitud a la API';

                    try {
                        var responseData = JSON.parse(jqXHR.responseText);

                        if (responseData && responseData.error) {
                            errorMessage = responseData.error;
                        } else if (responseData && responseData.details) {
                            // Si hay detalles, muestra los mensajes de detalle
                            errorMessage += '<br><strong>Detalles:</strong> ' + responseData.details;
                        }
                    } catch (e) {
                        // Si hay un error al analizar la respuesta JSON, muestra un mensaje de error genérico
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage,
                    });
                }
            });
        });
    });
</script>

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
@endsection