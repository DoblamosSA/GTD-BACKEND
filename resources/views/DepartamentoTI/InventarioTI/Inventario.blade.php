@extends('layouts.dashboard')

@section('content')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">INVENTARIO TECNOLOGIA</a>

                    </div>
                </nav>
                <div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #1c2a48;">
                                <h5 class="modal-title" id="addDeviceModalLabel" style="color: #fff;">Agregar Nuevo Dispositivo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addFormdispositivo">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="deviceStatus">Asignado A:</label>
                                            <select class="custom-select" name="Asignado_A" id="ResponsableCNC" style="width: 100%;">
                                                <option></option>
                                                @foreach($empleados as $empleadosSAP)
                                                <option value="{{$empleadosSAP->id}}">{{$empleadosSAP->CardName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="deviceName">Nombre del Equipo:</label>
                                            <input type="text" class="form-control" name="nombre_equipo">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceModel">Modelo:</label>
                                            <input type="text" class="form-control" name="modelo">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Marca:</label>
                                            <input type="text" class="form-control" name="marca">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="deviceStatus">Estado:</label>
                                            <select class="form-control" name="estado">
 <option value=""></option>
                                                <option value="Activo">Activo</option>
<option value="Disponible">Disponible</option>
                                                <option value="Inactivo">Inactivo</option>
       							<option value="Obsoleto">Obsoleto</option>
	
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Serial:</label>
                                            <input type="text" class="form-control" name="serial">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Sistema operativo:</label>
                                            <input type="text" class="form-control" name="sistema_operativo">
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="deviceStatus">Procesador:</label>
                                            <input type="text" class="form-control" name="procesador">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceStatus">Memoria Ram:</label>
                                            <input type="text" class="form-control" name="memoria_ram">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">hdd:</label>
                                            <input type="text" class="form-control" name="hdd">
                                        </div>

                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Sede:</label>
                                            <input type="text" class="form-control" name="sede">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Piso:</label>
                                            <input type="text" class="form-control" name="piso">
                                        </div>

                                    </div>
                                    <div class="form-row">


                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Area:</label>

                                            <select class="form-control" name="area">
                                                <option value=""></option>
                                                @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->Nombre_Area }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deviceBrand">Fecha Garantia:</label>
                                            <input type="date" class="form-control" name="fecha_garantia">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Fecha Compra:</label>
                                            <input type="date" class="form-control" name="fecha_compra">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Numero Factura SAP:</label>
                                            <input type="text" class="form-control" name="numero_facturasap">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Codigo Activo SAG:</label>
                                            <input type="text" class="form-control" name="codigo_Activosap">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Codigo Activo SAP:</label>
                                            <input type="text" class="form-control" name="codigoactivoSaG">
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary" id="GuardarInventarioBtn">Guardar en inventario</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">




                        <ul class="nav nav-tabs">

                            <li class="nav-item">
                                <a class="nav-link" href="">Licencias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">Monitores</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="">Impresoras</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Costo-No-Calidad.Indicadores')}}">Telefonia</a>
                            </li>



                        </ul>
                    </div>

                    <div class="d-md-flex justify-content-md-end">
                        <div class="col">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeviceModal">
                                <i class="fas fa-plus"></i> Agregar Dispositivo
                            </button>
                        </div>
                    </div>

                </div>
                <!-- Modal -->

                <!-- Formulario para la edición -->
                <div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #1c2a48;">
                                <h5 class="modal-title" id="editDeviceModalLabel" style="color: #fff;">Editar Inventario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para la edición -->
                                <form id="editDeviceForm">
                                    <div class="form-row">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="deviceStatus">Asignado A:</label>
                                                <select class="custom-select" name="Asignado_A" id="ResponsableCNC" style="width: 100%;">
                                                    <option></option>
                                                    @foreach($empleados as $empleadosSAP)
                                                    <option value="{{$empleadosSAP->id}}">{{$empleadosSAP->CardName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="editnombre_equipo">Nombre del Equipo:</label>
                                                <input type="text" class="form-control" name="nombre_equipo" id="editnombre_equipo">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="editmodelo">Modelo:</label>
                                                <input type="text" class="form-control" name="modelo" id="editmodelo">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="editmarca">Marca:</label>
                                                <input type="text" class="form-control" name="editmarca" id="editmarca">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editEstado">Estado:</label>
                                            <select class="form-control" name="Estado" id="editEstado">
                                                <option value="Libre">Libre</option>
                                                <option value="Ocupada">Ocupada</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="editserial">Serial:</label>
                                            <input type="text" class="form-control" name="serial" id="editserial">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editsistema_operativo">Sistema operativo:</label>
                                            <input type="text" class="form-control" name="sistema_operativo" id="editsistema_operativo">
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="editprocesador">Procesador:</label>
                                            <input type="text" class="form-control" name="procesador" id="editprocesador">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editmemoria_ram">Memoria Ram:</label>
                                            <input type="text" class="form-control" name="memoria_ram" id="editmemoria_ram">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="edithdd">hdd:</label>
                                            <input type="text" class="form-control" name="hdd" id="edithdd">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editsede">Sede:</label>
                                            <input type="text" class="form-control" name="sede" id="editsede">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="editpiso">Piso:</label>
                                            <input type="text" class="form-control" name="piso" id="editpiso">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="editarea">Area:</label>

                                            <select class="form-control" name="area" id="editarea">
                                                <option value=""></option>
                                                @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->Nombre_Area }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editfecha_garantia">Fecha Garantia:</label>
                                            <input type="date" class="form-control" name="fecha_garantia" id="editfecha_garantia">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editfecha_compra">Fecha Compra:</label>
                                            <input type="date" class="form-control" name="fecha_compra" id="editfecha_compra">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editnumerofacturasap">Numero Factura SAP:</label>
                                            <input type="text" class="form-control" name="numero_facturasap" id="editnumerofacturasap">
                                        </div>
                                        <!-- <div class="form-group col-md-4">
                                            <label for="editcodigo_Activosap">Codigo Activo SAG:</label>
                                            <input type="text" class="form-control" name="codigo_Activosap" id="editcodigo_Activosap">
                                        </div> -->
                                        <div class="form-group col-md-4">
                                            <label for="editcodigoactivoSaG">Codigo Activo SAG:</label>
                                            <input type="text" class="form-control" name="codigoactivoSaG" id="editcodigoactivoSaG">
                                        </div>



                                    </div>
                                    <input type="hidden" name="editId" id="editId" value="">
                                    <button type="submit" class="btn btn-primary" id="actualizarLicenciaBtn">Actualizar Licencia</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



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


                <div id="indicador" class="d-none text-center">
                    <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-2"></i>
                    <p class="mb-0">Cargando...</p>
                </div>
                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead class="table-dark">
                        <tr>

                            <th style="font-size: 12px;">NOMBRE EQUIPO</th>
                            <th style="font-size: 12px;">MARCA</th>
                            <th style="font-size: 12px;">MODELO</th>
                            <th style="font-size: 12px;">ESTADO</th>
                            <th style="font-size: 12px;">SERIAL</th>
                            <th style="font-size: 12px;">PROCESADOR</th>
                            <th style="font-size: 12px;">HDD</th>
                            <th style="font-size: 12px;">MEMORIA RAM</th>
                            <th style="font-size: 12px;">S.OPERATIVO</th>
                            <th style="font-size: 12px;">CODIGO SAG</th>
                            <th style="font-size: 12px;">CODIGO SAP</th>
                            <th style="font-size: 12px;">SEDE</th>
                            <th style="font-size: 12px;">PISO</th>
                            <th style="font-size: 12px;">ASIGNADO</th>
                            <th style="font-size: 12px;">FECHA GARANTIA</th>
                            <th style="font-size: 12px;">FECHA COMPRA</th>
                            <th style="font-size: 12px;">FACTURA COMPRA</th>
                            <th style="font-size: 12px;">ACCIONES</th>

                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @foreach($inventario as $inventario)
                        <tr>
                            <td>{{$inventario->nombre_equipo}}</td>
                            <td>{{$inventario->marca}}</td>
                            <td>{{$inventario->modelo}}</td>

                            <td style="font-size: 12px; background-color: {{ $inventario->estado == 'Activo' ? '' : '' }}">
                                @if($inventario->estado == 'Activo')
                                <span style="color: green;">
                                    <i class="fa fa-check-circle"></i> Activo
                                </span>
                                @else
                                <span style="color: red;">
                                    <i class="fa fa-times-circle"></i> Inactivo
                                </span>
                                @endif
                            </td>

                            <td>{{$inventario->serial}}</td>
                            <td>{{$inventario->procesador}}</td>

                            <td>{{$inventario->hdd}}</td>
                            <td>{{$inventario->memoria_ram}}</td>
                            <td>{{$inventario->sistema_operativo}}</td>
                            <td>{{$inventario->codigoactivoSaG}}</td>
                            <td>{{$inventario->codigo_Activosap}}</td>
                            <td>{{$inventario->sede}}</td>
                            <td>{{$inventario->piso}}</td>
                            <td>{{$inventario->asignado_A}}</td>
                            <td>{{$inventario->fecha_garantia}}</td>
                            <td>{{$inventario->fecha_compra}}</td>
                            <td>{{$inventario->numero_facturasap}}</td>
                            <td>
                                <button class="btn btn-outline-info btn-editar" data-id="{{ $inventario->id }}" data-nombre_equipo="{{ $inventario->nombre_equipo }}" data-marca="{{ $inventario->marca }}" data-modelo="{{$inventario->modelo }}" data-estado="{{ $inventario->estado }}" data-serial="{{ $inventario->serial }}" data-procesador="{{ $inventario->procesador }}" data-hdd="{{ $inventario->hdd }}" data-memoria_ram="{{ $inventario->memoria_ram }}" data-sistema_operativo="{{ $inventario->sistema_operativo }}" data-codigoactivoSaG="{{ $inventario->codigoactivoSaG }}" data-codigo_Activosap="{{ $inventario->codigo_Activosap }}" data-sede="{{ $inventario->sede }}" data-piso="{{ $inventario->piso }}" data-asignado_A="{{ $inventario->asignado_A }}" data-fecha_garantia="{{ $inventario->fecha_garantia }}" data-fecha_compra="{{ $inventario->fecha_compra }}" data-numero_facturasap="{{ $inventario->numero_facturasap }}" title="Editar">
                                    <i class="fa fa-fw fa-edit"></i>
                                </button>


                                <button class="btn btn-outline-danger btn-eliminar" data-id="{{$inventario->id }}" title="Eliminar">
                                    <i class="fa fa-fw fa-trash"></i>
                                </button>
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
</div>
</div>



@endsection
@section('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>


<script>
    $(document).ready(function() {
        // Evento click en el botón de editar
        $('#datatableinfo').on('click', '.btn-editar', function() {
            var licenciaId = $(this).data('id');
            console.log('Licencia ID:', licenciaId);
            var nombre_equipo = String($(this).data('nombre_equipo'));
            var modelo = String($(this).data('modelo'));
            var estado = String($(this).data('estado'));
            var serial = String($(this).data('serial'));
            var marca = String($(this).data('marca'));
            var sistema_operativo = String($(this).data('sistema_operativo'));
            var procesador = String($(this).data('procesador'));
            var memoria_ram = String($(this).data('memoria_ram'));
            var hdd = String($(this).data('hdd'));
            var sede = String($(this).data('sede'));
            var piso = String($(this).data('piso'));
            var area = String($(this).data('area'));
            var fecha_garantia = String($(this).data('fecha_garantia'));
            var fecha_compra = String($(this).data('fecha_compra'));
            var numerofacturasap = String($(this).data('numero_facturasap'));
            var codigo_Activosap = String($(this).data('codigo_Activosap'));
            var codigoactivoSaG = String($(this).data('codigoactivoSaG')); 


            var key = String($(this).data('key'));
            var correoAsociado = String($(this).data('correoAsociado')); // Corregir aquí

            // Llenar los campos del modal con los datos del inventario
            $('#editnombre_equipo').val(nombre_equipo);
            $('#editmodelo').val(modelo);
            $('#editmarca').val(marca);
            $('#editEstado').val(estado);
            $('#editserial').val(serial);
            $('#editsistema_operativo').val(sistema_operativo);
            $('#editprocesador').val(procesador);
            $('#editmemoria_ram').val(memoria_ram);
            $('#edithdd').val(hdd);
            $('#editsede').val(sede);
            $('#editpiso').val(piso);
            $('#editarea').val(area);
            $('#editfecha_garantia').val(fecha_garantia);
            $('#editfecha_compra').val(fecha_compra);
            $('#editnumerofacturasap').val(numerofacturasap);
            $('#editcodigo_Activosap').val(codigo_Activosap);
            $('#editcodigoactivoSaG').val(codigoactivoSaG); 
            $('#editId').val(licenciaId);
            $('#editKey').val(key);
            $('#editCorreoAsociado').val(correoAsociado);
            // Mostrar el modal de edición
            $('#editDeviceModal').modal('show');
        });

        $('#editDeviceForm').submit(function(event) {
            event.preventDefault();

            // Obtener datos del formulario de edición
            var editData = $(this).serialize();
            editData += '&_token=' + $('meta[name="csrf-token"]').attr('content'); // Agregar el token CSRF
            console.log('ID a actualizar:', $('#editId').val());
            // Enviar una solicitud AJAX PUT al servidor
            $.ajax({
                type: 'PUT',
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/ActualizarLicencia/' + $('#editId').val(),
                data: editData,
                success: function(response) {
                    // Manejar la respuesta exitosa
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message, // Puedes acceder a los mensajes de la respuesta
                    });

                    // Cerrar el modal de edición
                    $('#editDeviceModal').modal('hide');

                    // Recargar la página (puedes cambiar esto según tus necesidades)
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    var errorMessage = xhr.responseJSON.error || 'Error al actualizar el inventario';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#ResponsableCNC').chosen({
            allow_clear: true,
            placeholder_text_single: 'Seleccionar empleado',
            width: '100%'
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#addFormdispositivo').submit(function(event) {
            event.preventDefault();

            var formData = $(this).serialize();
            formData += '&_token=' + $('meta[name="csrf-token"]').attr('content'); // Agregar el token CSRF

            $.ajax({
                type: 'POST',
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/GuardarInventario',
                data: formData,
                success: function(response) {
                    // SweetAlert2 para éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Registro creado correctamente',
                    });
                    location.reload();
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        // Manejar errores de validación
                        var validationErrors = xhr.responseJSON.errors;
                        var errorMessage = 'Error de validación:\n';
                        $.each(validationErrors, function(field, messages) {
                            errorMessage += field + ': ' + messages.join(', ') + '\n';
                        });

                        // SweetAlert2 para errores de validación
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            text: errorMessage,
                        });
                    } else {
                        // Manejar otros errores
                        var errorMessage = xhr.responseJSON.error || 'Error al crear el dispositivo';

                        // SweetAlert2 para otros errores
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                }
            });
        });
    });
</script>
@endsection