@extends('layouts.dashboard')

@section('content')
<BR><BR>

<style>
    .selected-row {
        background-color: #F07A29;
        /* Cambia el color según tus preferencias */
    }
</style>
<style>
    .detalle-container {
        display: none;
    }

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
</style>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <br>
            <div class="card-header" style="background-color: #1c2a48;">

                <div class="container">
                    <header class="py-2" style="text-align: center; ">
                        <h4><b style="color: #fff; font-size:20px">SOLICITUDES DE COMPRA</b></h4>
                    </header>

                </div>

            </div>

            <br>

            <div id="loading-overlaysestados" class="loading-overlay">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-pulse"></i>
                    <span>cargando....</span>
                </div>
            </div>
            <section class="container-fluid">
                <div class="table-responsive" class="container-fluid">
                    <table id="" class="table" style="width: 100%;">

                        <thead>
                            <tr>
                                <th style="font-size: 10px; width: 10%;">CODIGO SOLICITUD</th>
                                <th style="font-size: 10px; width: 10%;">FECHA SOLICITUD</th>
                                <th style="font-size: 10px;">SOLICITANTE</th>
                                <th style="font-size: 10px;">APROBACIÓN</th>

                                <th style="font-size: 10px;">DETALLE SOLICITUD</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudescompras as $solicitud)
                            <tr>
                                <td style="font-size: 14px; text-transform: uppercase;">{{$solicitud->id}}</td>
                                <td style="font-size: 14px; text-transform: uppercase;">{{$solicitud->created_at}}</td>
                                <td style="font-size: 14px; text-transform: uppercase;">{{$solicitud->RequesterName}}</td>

                                <td style="font-size: 14px;">
                                    <div class="btn-group" role="group" aria-label="Botones de acción">
                                       
                                        <button type="button" class="btn btn-success btn-aprobar" data-solicitud-id="{{ $solicitud->id }}">
                                            <i class="fas fa-check"></i>Aprobar
                                        </button>
                                       
                                        <button type="button" class="btn btn-danger btn-rechazar" data-solicitud-id="{{ $solicitud->id }}">
                                            <i class="fas fa-times"></i>Rechazar
                                        </button>

                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comentarioModal{{ $solicitud->id }}" data-solicitud-id="{{ $solicitud->id }}">
                                            <i class="fas fa-comment"></i> Comentario
                                        </button>
                                        <button type="button" class="btn btn-primary ver-detalle" data-solicitud-id="{{ $solicitud->id }}">
                                            <i class="fas fa-info-circle"></i> Detalles
                                        </button>
                                        @if($solicitud->anexos->isNotEmpty())
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-file-pdf text-danger" title="Anexos solicitud de compra"></i> Anexos
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $solicitud->id }}">
                                                <h6 class="dropdown-header">Documentos Adjuntos</h6>
                                                @foreach($solicitud->anexos as $anexo)
                                                @php
                                                // Quitar el prefijo de la ruta almacenada
                                                $nombreArchivo = str_replace("public/AdjuntosSolicitudCompra/", "", $anexo->Ruta_documento_Adjunto);
                                                @endphp
                                                <a class="dropdown-item" href="{{ url('ver-anexos-solicitudes-compra', $nombreArchivo) }}" target="_blank">
                                                    <i class="fas fa-file-pdf text-danger"></i> {{ $nombreArchivo }}
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted">No hay adjuntos</span>
                                        @endif
                                    </div>
                                </td>




                                <td>

                                    <div class="detalle-container">
                                        <table class="detalles" style="width: 100%; background-color:#fff">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 10px; width: 10%;">Materiales</th>
                                                    <th style="font-size: 10px; width: 10%;">Descripcion</th>
                                                    <th style="font-size: 10px; width: 10%;">Texto libre</th>
                                                    <th style="font-size: 10px; width: 10%;">Cantidad</th>
                                                    <th style="font-size: 10px; width: 10%;">Almacen</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </td>

                            </tr>
                            <div class="modal fade" id="comentarioModal{{ $solicitud->id }}" tabindex="-1" role="dialog" aria-labelledby="comentarioModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #1c2a48;">
                                            <h5 class="modal-title" id="comentarioModalLabel" style="color: #fff; ">Agregar
                                                Comentario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form id="formComentario{{$solicitud->id}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="comentario">Comentario:</label>
                                                    <textarea class="form-control" id="comentario{{$solicitud->id}}" name="comentario" rows="4" required></textarea>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="guardarComentario({{ $solicitud->id }})">Guardar Comentario</button>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script>
    $(document).ready(function() {
        // Manejar clic en el enlace "VISUALIZAR DETALLE"
        $('.ver-detalle').on('click', function(e) {
            e.preventDefault(); // Evitar que el enlace redireccione

            var solicitudId = $(this).data('solicitud-id');
            var detalleContainer = $(this).closest('tr').find('.detalle-container');

            // Realizar la petición AJAX
            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/obtener-detalles-solicitud/' + solicitudId,
                type: 'GET',
                success: function(response) {
                    // Limpiar el cuerpo de la tabla de detalles
                    console.log(response);
                    detalleContainer.find('.detalles tbody').empty();

                    if (response.sucess && Array.isArray(response.sucess) && response.sucess.length > 0) {
                        // Recorrer los detalles y agregarlos a la tabla de detalles
                        $.each(response.sucess, function(index, detalle) {
                            var newRow = '<tr>' +
                                '<td style="font-size: 10px;">' + detalle.material.ItemCode + '</td>' +
                                '<td style="font-size: 10px;">' + detalle.Descripcion + '</td>' +
                                '<td style="font-size: 10px;">' + detalle.TextoLibre + '</td>' +

                                '<td style="font-size: 10px; width: 10%;">' + detalle.Cantidad + '</td>' +
                                '<td style="font-size: 10px; width: 10%;">' + detalle.Almacen + '</td>' +

                                '</tr>';

                            detalleContainer.find('.detalles tbody').append(newRow);
                        });

                        detalleContainer.show();
                    } else {
                        // Si no hay detalles, puedes mostrar un mensaje o realizar alguna acción
                        console.log('No se encontraron detalles para la solicitud.');
                    }
                },
                error: function(error) {
                    console.error('Error al obtener detalles:', error);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Escuchar el evento submit del formulario
        $('#formularioConsultassoliccompras').on('submit', function(event) {
            // Prevenir el envío por defecto del formulario
            event.preventDefault();

            // Realizar la solicitud Ajax
            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/Solicitudes-compra-consultar',
                type: 'GET',
                dataType: 'json',
                data: $(this).serialize(), // Enviar los datos del formulario
                success: function(response) {
                    // Manejar la respuesta exitosa
                    if (response.solicitudesCompra) {
                        // Limpiar la tabla antes de agregar nuevas filas
                        $('#tablaSolicitudes').empty();

                        // Recorrer las solicitudes y agregar filas a la tabla
                        $.each(response.solicitudesCompra, function(index, solicitud) {
                            // Agrega la clase 'text-success' si el estado es 'Aprobada'
                            var estadoClass = solicitud.estado === 'Aprobada' ? 'text-success' : '';

                            // Muestra "No generado en SAP" si DocNum o DocEntry son nulos, de lo contrario, muestra los valores
                            var docNumValue = solicitud.DocNum ?? 'Pendiente en SAP';
                            var docEntryValue = solicitud.DocEntry ?? 'Pendiente en SAP';

                            // Convierte el ID en un enlace (link)
                            var idLink = '<a href="/detalle-solicitud/' + solicitud.id + '">' + solicitud.id + '</a>';

                            // Agrega un botón adicional con el icono de Font Awesome solo si DocNum o DocEntry son nulos
                            var sapButton = (solicitud.DocNum === null || solicitud.DocEntry === null) ?
                                '<button type="button" class="btn btn-info btn-sm" onclick="abrirSAPModal(' + solicitud.id + ')"><i class="fas fa-database"></i> SSAP</button>' :
                                '';

                            $('#tablaSolicitudes').append('<tr><td>' + idLink + '</td><td>' + solicitud.RequriedDate + '</td><td class="' + estadoClass + '">' + solicitud.estado + '</td><td>' + docNumValue + '</td><td>' + docEntryValue + '</td><td>' + sapButton + '</td></tr>');
                        });
                    } else {
                        console.error('No se encontraron solicitudes de compra.');
                    }
                },
                error: function(error) {
                    // Manejar errores en la solicitud Ajax
                    console.error('Error al consultar las solicitudes de compra.');
                }
            });
        });

        // Manejar clic en el enlace de "Solicitudes"
        $('#solicitudesAprobadas-tab').on('click', function() {
            // Simular el envío del formulario al hacer clic en el enlace
            $('#formularioConsultassoliccompras').submit();
        });

        // Función para abrir el modal de SAP
        // Función para mostrar el div de carga
        function mostrarDivDeCarga() {
            // Muestra el div de carga
            $('#loading-overlays').css('display', 'flex');
        }

        // Función para ocultar el div de carga
        function ocultarDivDeCarga() {
            // Oculta el div de carga
            $('#loading-overlays').css('display', 'none');
        }

        // Función para abrir el modal de SAP
        window.abrirSAPModal = function(id) {
            // Lógica para abrir el modal de SAP
            console.log('Abrir modal de SAP para la solicitud con ID: ' + id);
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Realizar la solicitud Ajax para enviar el ID a la ruta correspondiente
            // Muestra el div de carga mientras se realiza la solicitud
            mostrarDivDeCarga();

            // Realizar la solicitud Ajax para enviar el ID a la ruta correspondiente
            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/generarSolicitudCompradesdeAplicativo/' + id,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: csrfToken
                },
                success: function(response) {
                    // Oculta el div de carga al finalizar la solicitud
                    ocultarDivDeCarga();

                    // Maneja la respuesta de la API
                    if (response.success) {
                        // Muestra SweetAlert2 con el número de documento y recarga la página
                        Swal.fire({
                            icon: 'success',
                            title: 'Solicitud Generada con Éxito',
                            text: 'Número de solicitud: ' + response.DocNum,
                        }).then(function() {
                            // Recarga la página después de cerrar la alerta
                            location.reload();
                        });
                    } else {
                        // Muestra SweetAlert2 con el mensaje de error y detalles si disponibles
                        var errorMessage = 'Error en la solicitud a la API';

                        if (response.error) {
                            errorMessage = response.error;
                        }

                        // Verifica si hay detalles en la respuesta
                        if (response.details) {
                            errorMessage += '<br><strong>Detalles:</strong> ' + JSON.stringify(response.details, null, 2);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessage,
                        });
                    }
                },
                error: function(error) {
                    // Oculta el div de carga al finalizar la solicitud
                    ocultarDivDeCarga();

                    // Maneja los errores de la API
                    console.error('Error en la solicitud a la API:', error);

                    // Muestra SweetAlert2 con un mensaje de error genérico
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Respuesta SAP: ' + error.responseJSON.error,
                    });

                    // Accede a los detalles del error proporcionados por el controlador
                    if (error.responseJSON && error.responseJSON.error) {
                        console.log('Mensaje de error:', error.responseJSON.error);
                    }
                    if (error.responseJSON && error.responseJSON.details) {
                        console.log('Detalles del error:', error.responseJSON.details);
                    }
                }
            });
        };

    });
</script>
<script>
    $(document).ready(function() {
        $('.btn-aprobar, .btn-rechazar').click(function() {
            var solicitudId = $(this).data('solicitud-id');
            var accion = $(this).hasClass('btn-aprobar') ? 'aprobar' : 'rechazar';
            var usuarioAutenticadoId = '{{ auth()->user()->id }}';
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Mostrar el spinner mientras se realiza la llamada AJAX
            var loadingOverlay = $('#loading-overlaysestados');
            loadingOverlay.show();

            // Pregunta de confirmación con SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, estoy seguro'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes realizar la llamada AJAX para aprobar o rechazar la solicitud
                    $.ajax({
                        type: 'POST',
                        url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/aprobar-solicitudcompragerenciaaplicacion/' + solicitudId + '/' + usuarioAutenticadoId,
                        data: {
                            accion: accion,
                            _token: csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                // Mostrar mensaje de éxito
                                Swal.fire('¡Éxito!', 'Gracias por tu aprobación', 'success').then(() => {
                                    // Recargar la página después de cerrar la alerta
                                    location.reload();
                                });
                            } else {
                                // Mostrar mensaje de error del servidor
                                Swal.fire('¡Error!', 'Error al ' + accion + ' la solicitud: ' + response.message, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', error);
                            // Mostrar mensaje de error genérico
                            Swal.fire('¡Error!', 'Error en la solicitud AJAX', 'error');
                        },
                        complete: function() {
                            // Ocultar el spinner cuando la llamada AJAX ha terminado
                            loadingOverlay.hide();
                        }
                    });
                } else {
                    // Ocultar el spinner si el usuario cancela la acción
                    loadingOverlay.hide();
                }
            });
        });
    });
</script>


<script>
    function guardarComentario(solicitudId) {
        var comentario = $('#comentario' + solicitudId).val();

        $.ajax({
            type: 'POST',
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/api/solicitud-compra-comentarios/' + solicitudId + '/actualizar-comentario',
            data: {
                comentario: comentario,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Actualización exitosa
                    Swal.fire({
                        icon: 'success',
                        title: 'Comentario actualizado',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 800 // 2 segundos
                    });

                    // Cerrar el modal después de 2 segundos
                    setTimeout(function() {
                        $('#comentarioModal' + solicitudId).modal('hide');
                    }, 1000);

                    // Puedes realizar acciones adicionales si es necesario
                    console.log(response.message);
                } else {
                    // Manejar errores
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Manejar errores de AJAX
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud AJAX'
                });
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }
</script>


<script>
    // Script para manejar el clic en el botón "Ver Anexos"
    $('.btn-ver-anexos').on('click', function() {
        var solicitudId = $(this).data('solicitud-id');
        $('#anexosModal').modal('show');
    });
</script>



@endsection