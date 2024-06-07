@extends('layouts.dashboard')

@section('content')
<br><br> 

<style>

#datatableinfo th {
    background-color: #1c2a48;
    color: white;
}



</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                   <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#1c2a48;">

                    <a class="navbar-brand" href="#">GESTIÓN CARTERA</a>
                    <button type="button" class="btn btn-outline-info" id="btnGenerarCartera">
                        <i class="fas fa-wallet"></i><b style="color: #fff;"> Asistente Cartera</b>
                    </button>

                    <button type="button" class="btn btn-outline-info" id="btnEnviarCorreoMasivo">
                        <i class="fas fa-envelope"></i> <b style="color: #fff;">Envío correo masivo</b>
                    </button>

                </nav>
                <br>

                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>
                            <th style="font-size: 15px; width: 20px;">
                                <input type="checkbox" id="selectAll" style="transform: scale(0.8);" class="form-control" />
                            </th>
                            <th style="font-size: 12px;">DOCUMENTO</th>
                            <th style="font-size: 12px;">FECHA DOCUMENTO</th>
                            <th style="font-size: 12px;">FECHA VENCIMIENTO</th>
                            <th style="font-size: 12px;">DIAS VENCIDOS</th>
                            <!-- <th style="font-size: 10px;">Código Cliente</th> -->
                            <th style="font-size: 12px;">NOMBRE CLIENTE</th>
                            <th style="font-size: 12px;">VENDEDOR</th>
                            <th style="font-size: 12px;">ESTADO</th>
                            <th style="font-size: 12px;">ENVIO CORREO</th>
                            <th style="font-size: 12px;">TOTAL DOCUMENTO</th>
                            <th style="font-size: 12px;">PAGO HASTA LA FECHA</th>
                            <th style="font-size: 12px;">SALDO PENDIENTE</th>
                            <th style="font-size: 12px;">CORREO CLIENTE</th>
                            <th style="font-size: 12px;">ACCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cuentasporpa as $cuenta)
                        <tr>
                            <td style="width: 23px;">
                                <input type="checkbox"  name="selectedItems[]" value="{{ $cuenta->id }}" data-email="{{ $cuenta->E_Mail }}" />
                            </td>
                            <td style="font-size: 12px;">{{ $cuenta->documento }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->Fecha_Documento }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->Fecha_Vencimiento }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->Dias_Vencidos }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->Nombre_Cliente }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->Vendedor }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->Estado_Documento }}</td>
                            <td style="font-size: 12px; background-color: {{ $cuenta->EnvioCorreo == 1 ? '' : '' }}">
                                @if($cuenta->EnvioCorreo == 1)
                                <span style="color: green;">
                                    <i class="fa fa-check-circle"></i> Enviado
                                </span>
                                @else
                                <span style="color: red;">
                                    <i class="fa fa-times-circle"></i> Enviado 
                                </span>
                                @endif
                            </td>

                            <td style="font-size: 12px;">{{ number_format($cuenta->Total_Documento) }}</td>
                            <td style="font-size: 12px;">{{ number_format($cuenta->pagado_hasta_la_fecha) }}</td>
                            <td style="font-size: 12px;">{{ number_format($cuenta->Saldo_Pendiente) }}</td>
                            <td style="font-size: 12px;">{{ $cuenta->E_Mail }}</td>
                            <td style="font-size: 12px;">
                                <button class="btn btn-outline-info btn-editar" data-id="{{ $cuenta->id }}" title="Seguimiento">
                                    <i class="fa fa-fw fa-edit"></i>
                                </button>

                                <button type="button" class="btn btn-outline-success btn-modificar-correo" data-toggle="modal" data-target="#modalModificarCorreo" data-codigocliente="{{ $cuenta->Codigo_cliente }}" title="Modificar correo SAP" onclick="capturarCodigoCliente('{{ $cuenta->Codigo_cliente }}')">
                                    <i class="fas fa-envelope"></i>
                                </button>


                                <button type="button" class="btn btn-outline-info" onclick="verComentarios({{ $cuenta->id }})" title="Comentarios del seguimiento">
                                    <i class="fas fa-eye"></i>
                                </button>


                            </td>
                        </tr>
                        @endforeach

                    </tbody>



                </table>




            </div>

            <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #1c2a48; color:#fff">
                            <h5 class="modal-title" id="editarModalLabel">Generar seguimiento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formSeguimiento">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Fecha del seguimiento</span>
                                    <input type="date" name="Fecha_Seguimiento" class="form-control">
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Fecha del compromiso</span>
                                    <input type="date" name="Fecha_compromiso_pago" class="form-control">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Estado</span>
                                    <select class="form-control" name="Estado_Documento">
                                        <option value=""></option>
                                        <option value="Proxima semana">Proxima semana</option>
                                        <option value="Cancelado">Cancelado</option>
                                        <option value="Nota credito">Nota crédito</option>
                                        <option value="Critico">Critico</option>
					<option value="Abogado">Abogado</option>

                                    </select>
                                </div>

                                <br>

                                <div class="input-group">
                                    <span class="input-group-text">Comentarios</span>
                                    <textarea class="form-control" name="comentario" aria-label="With textarea"></textarea>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="verComentariosModal" tabindex="-1" role="dialog" aria-labelledby="verComentariosModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #1c2a48; color:#fff">
                            <h5 class="modal-title" id="verComentariosModalLabel">Comentarios cuentas por pagar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Seguimiento</th>
                                        <th>Fecha Seguimiento</th>
                                        <th>Fecha Compromiso</th>
                                        <th>Comentarios</th>
                                    </tr>
                                </thead>
                                <tbody id="comentariosTableBody">
                                    <!-- Aquí se agregarán las filas de la tabla dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalModificarCorreo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modificar Correo SAP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formularioModificarCorreo">
                                <input class="form-control" type="text" name="CorreoclientecarteraSAP" id="CorreoclientecarteraSAP" placeholder="Correo gestión cartera">
                                <input type="hidden" name="CodigoCliente" id="CodigoCliente" value="">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>



            <div id="loading-overlays" class="loading-overlay">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-pulse"></i>
                    <span>Ejecutando operación...</span>
                </div>
            </div>

        </div>

    </div>
</div>


@endsection


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inicializar DataTable con encabezados fijos y desplazamiento vertical
        $('#datatable').DataTable({
            fixedHeader: true,
            scrollY: "400px", // Puedes ajustar la altura según tus necesidades
            scroller: true,
            columnDefs: [{
                    width: '20px',
                    targets: 0
                }, // Ajustar el ancho de la primera columna
                {
                    width: '10%',
                    targets: 2
                }, // Ajustar el ancho de la columna "DESCRIPCIÓN"
                {
                    width: '10px',
                    targets: [1, 3, 4, 5, 6, 7, 8, 9]
                }
            ],
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Función para limpiar los campos del formulario
        function limpiarFormulario() {
            $('#formSeguimiento')[0].reset();
        }

        $('.btn-editar').click(function() {
            const idCuenta = $(this).data('id');
            $('#editarModal').modal('show');
            $('#formSeguimiento').data('idCuenta', idCuenta);
            limpiarFormulario();
        });

        $('#formSeguimiento').submit(function(e) {
            e.preventDefault();

            // Evitar la recarga de la página
            e.stopPropagation();

            const formData = $(this).serialize();
            const idCuenta = $('#formSeguimiento').data('idCuenta');
            const url = `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/gerarseguimiento_cuentasporpagar/${idCuenta}`;

            axios.post(url, formData, {
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.data.message,
                    }).then(() => {
                        $('#editarModal').modal('hide');
                        limpiarFormulario();
                    });

                    console.log(response.data);
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;

                        // Iterar sobre los errores y mostrarlos
                        Object.keys(errors).forEach(field => {
                            const errorMessage = errors[field][0];
                            // Muestra el mensaje de error en algún lugar de tu interfaz
                            console.error(`Error en el campo ${field}: ${errorMessage}`);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al enviar la solicitud: ' + JSON.stringify(error.response.data),
                        });
                        console.error('Error al enviar la solicitud:', error);
                    }
                });

            // Evitar que el formulario se envíe automáticamente
            return false;
        });
    });
</script>




<!-- Asegúrate de incluir jQuery antes de este script -->
<script>
    function verComentarios(id_cuenta) {
        // Hacer la llamada AJAX
        $.ajax({
            url: `{{ url('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/cuentas-porpagar/obtener-comentarios') }}/${id_cuenta}`,
            type: 'GET',
            success: function(data) {
                // Limpiar el cuerpo de la tabla
                $('#comentariosTableBody').empty();

                // Iterar sobre los comentarios y agregarlos a la tabla
                $.each(data.comentarios, function(index, comentario) {
                    $('#comentariosTableBody').append(
                        `<tr>
            
                            <td>${comentario.cuentasporpagar_id}</td>
                            <td>${comentario.Fecha_Seguimiento}</td>
                            <td>${comentario.Fecha_compromiso_pago}</td>
                            <td>${comentario.comentario}</td>
                        </tr>`
                    );
                });

                // Mostrar el modal
                $('#verComentariosModal').modal('show');
            },
            error: function(error) {
                // Manejar el error según sea necesario
                console.error('Error al obtener comentarios:', error);
            }
        });
    }
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("btnGenerarCartera").addEventListener("click", function() {
            // Muestra el elemento de carga al hacer clic en el botón
            $("#loading-overlays").show();

            fetch('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/cuentas-porpagar', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {


                    // Oculta el elemento de carga después de mostrar los datos
                    $("#loading-overlays").hide();

                    // Recarga la página
                    location.reload();
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    // Oculta el elemento de carga en caso de error
                    $("#loading-overlays").hide();
                });
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Función para limpiar los campos del formulario
        function limpiarFormulario() {
            $('#formSeguimiento')[0].reset();
        }

        // Evento de clic en el checkbox de encabezado para seleccionar todos
        $('#selectAll').change(function() {
            const isChecked = $(this).prop('checked');
            $('input[name="selectedItems[]"]').prop('checked', isChecked);
        });

        // Evento de clic en el checkbox de una fila
        $('input[name="selectedItems[]"]').change(function() {
            const totalCheckboxes = $('input[name="selectedItems[]"]').length;
            const checkedCheckboxes = $('input[name="selectedItems[]"]:checked').length;

            // Si todos los checkboxes están marcados, marca el checkbox de encabezado, de lo contrario, desmárcalo
            $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        $('.btn-editar').click(function() {
            const idCuenta = $(this).data('id');
            $('#editarModal').modal('show');
            $('#formSeguimiento').data('idCuenta', idCuenta);
            limpiarFormulario();
        });

        $('#formSeguimiento').submit(function(e) {
            e.preventDefault();

            // Evitar la recarga de la página
            e.stopPropagation();

            const formData = $(this).serialize();
            const idCuenta = $('#formSeguimiento').data('idCuenta');
            const url = `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/gerarseguimiento_cuentasporpagar/${idCuenta}`;

            axios.post(url, formData, {
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.data.message,
                    }).then(() => {
                        $('#editarModal').modal('hide');
                        limpiarFormulario();
                    });

                    console.log(response.data);
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;

                        // Iterar sobre los errores y mostrarlos
                        Object.keys(errors).forEach(field => {
                            const errorMessage = errors[field][0];
                            // Muestra el mensaje de error en algún lugar de tu interfaz
                            console.error(`Error en el campo ${field}: ${errorMessage}`);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al enviar la solicitud: ' + JSON.stringify(error.response.data),
                        });
                        console.error('Error al enviar la solicitud:', error);
                    }
                });

            // Evitar que el formulario se envíe automáticamente
            return false;
        });
    });
</script>

<script>
    function capturarCodigoCliente(codigoCliente) {
        // Asignar el código del cliente al campo oculto
        $('#CodigoCliente').val(codigoCliente);
    }

    function guardarCambios() {
        // Obtener los valores de los campos del formulario
        var correoClienteCarteraSAP = document.getElementById('CorreoclientecarteraSAP').value;
        var codigoCliente = document.getElementById('CodigoCliente').value;

        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Enviar datos al backend mediante AJAX
        $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/actualizar-correo-sap', // Cambia la URL según tu ruta Laravel
                method: 'PATCH', // Usa PATCH en lugar de POST
                data: {
                    CorreoclientecarteraSAP: correoClienteCarteraSAP,
                    CodigoCliente: codigoCliente
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Agrega el token CSRF a la cabecera
                },
            })
            .then(response => {
                // Verificar si la respuesta tiene un mensaje de éxito
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                    });
                } else {
                    // En caso de respuesta inesperada
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Respuesta inesperada del servidor',
                    });
                }
            })
            .catch(error => {
                // Verificar si la respuesta tiene un mensaje de error
                if (error.response && error.response.data && error.response.data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.response.data.error,
                    });
                } else {
                    // En caso de error inesperado
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error inesperado al enviar la solicitud',
                    });
                }
            })
            .finally(() => {
                // Cerrar el modal después de enviar la solicitud, incluso en caso de error
                $('#modalModificarCorreo').modal('hide');
            });
    }
</script>


<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    var dataTable;

    $('#formBusqueda').submit(function (e) {
        e.preventDefault();

        if ($.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().clear().destroy();
        }

        const fechaInicio = $('#Fecha_Documento').val();
        const fechaFin = $('#Fecha_Vencimiento').val();

        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/cuentasporpagarfechas',
            method: 'GET',
            data: {
                Fecha_Documento: fechaInicio,
                Fecha_Vencimiento: fechaFin,
                _token: '{{ csrf_token() }}',
            },
            success: function (data) {
                dataTable = $('#datatable').DataTable({
                    data: data,
                    columns: [
                        // ... Configuración de las columnas
                    ],
                });
            },
            error: function (error) {
                console.error('Error en la consulta AJAX:', error);
            }
        });
    });

    // Inicializar DataTables en la carga inicial de la página
    $(document).ready(function () {
        dataTable = $('#datatable').DataTable();
    });
});
</script> -->
<script>
    function capturarCodigoCliente(codigoCliente) {
        // Asignar el código del cliente al campo oculto
        $('#CodigoCliente').val(codigoCliente);
    }

    function guardarCambios() {
        // Obtener los valores de los campos del formulario
        var correoClienteCarteraSAP = $('#CorreoclientecarteraSAP').val();
        var codigoCliente = $('#CodigoCliente').val();

        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Enviar datos al backend mediante AJAX
        $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/actualizar-correo-sap',
                method: 'PATCH',
                data: {
                    CorreoclientecarteraSAP: correoClienteCarteraSAP,
                    CodigoCliente: codigoCliente
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                    });
                    // Recarga la página
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,

                    });
                    $("#loading-overlays").hide();

                    // Recarga la página
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al realizar la solicitud al servidor.',
                });
            })
            .finally(() => {
                // Cerrar el modal después de enviar la solicitud
                $('#modalModificarCorreo').modal('hide');
            });
    }
</script>
<script>
    $(document).ready(function() {
        // Funcionalidad para el botón 'btnEnviarCorreoMasivo'
        $('#btnEnviarCorreoMasivo').click(function() {
            // Mostrar mensaje de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción enviará correos electrónicos masivos. ¿Quieres continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, enviar correos',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Usuario confirmó, proceder con el envío de correos
                    const selectedItems = $('input[name="selectedItems[]"]:checked').map(function() {
                        const id = $(this).val();
                        const email = $(this).data('email');
                        return {
                            id,
                            email
                        };
                    }).get();

                    if (selectedItems.length > 0) {
                        const csrfToken = $('meta[name="csrf-token"]').attr('content');

                        axios.post('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/enviar-correo-masivo-clientessaldopendiente', {
                                selectedItems: selectedItems
                            }, {
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            })
                            .then(response => {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: response.data.message,
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al enviar correos electrónicos: ' + error.response.data.message,
                                });
                            });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Advertencia',
                            text: 'Selecciona al menos un registro para enviar correos electrónicos.',
                        });
                    }
                }
            });
        });
    });
</script>







<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    .bg-header {
        color: grey;
        text-align: center;
        padding: 1em 0;
        border-radius: 10px 10px 0 0;
    }

    .inventory-section,
    .mrp-section {
        margin: 20px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
    }

    .btn-asistente {
        background-color: grey;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        cursor: pointer;
    }



    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }


    .full-height {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .flex-grow {
        flex-grow: 1;
    }

    /* Estilos para el indicador de carga */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 1000;
    }

    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .loading-spinner i {
        font-size: 40px;
        color: #0056b3;
    }

    .loading-spinner span {
        display: block;
        font-size: 18px;
        margin-top: 10px;
    }

    .btn-asistente {
        background-color: #0056b3;
    }
</style>