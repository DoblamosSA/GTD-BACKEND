@extends('layouts.dashboard')

@section('template_title')
Solicitudes de crédito
@endsection



@section('content')
<br><br> <br>
<link rel="stylesheet" href="{{ asset('estilosgestioncartera/solicitudescredito.css') }}">


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">GESTIÓN DE CARTERA</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">




                                <li class="nav-item dropdown">

                                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Créditos
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{url('Solicitudes-creditos')}}">Nuevas Solicitudes</a>
                                        <a class="dropdown-item" href="{{url('Solicitudes-creditos-rechazadas')}}">Solicitudes Rechazadas
                                        </a>
                                        <a class="dropdown-item" href="">Solicitudes Aprobadas
                                        </a>



                                    </div>

                                </li>


                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Informes Cartera
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="">Historial
                                            de
                                            Cotizaciones</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Informes Tesoreria
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="">Nuevas Solicitudes</a>
                                        <a class="dropdown-item" href="">Solicitudes Rechazadas
                                            Solicitudes Aprobadas</a>

                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Cartera
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{url('Gestion-Cartera')}}">Gestión de cartera
                                        </a>
                                        <a class="dropdown-item" href="{{url('Solicitudes-creditos')}}">Solicitudes de credito
                                        </a>
                                        <a class="dropdown-item" href="">exportar excel
                                            seguimientos</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <br>



                <br>




                <div id="indicador" class="d-none text-center">
                    <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-2"></i>
                    <p class="mb-0">Cargando...</p>
                </div>
                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead class="table-dark">
                        <tr>
                            <th style="font-size: 10px">ID</th>
                            <th style="font-size: 10px;">EMPRESA</th>
                            <th style="font-size: 10px;">NIT</th>
                            <th style="font-size: 10px;">MONTO SOLICITADO</th>
                            <th style="font-size: 10px;">PLAZO CRÉDITO DIAS</th>
                            <th style="font-size: 10px;">ADJUNTOS CLIENTE</th>
                            <th style="font-size: 10px;">ADJUNTOS CARTERA</th>
                            <th style="font-size: 10px;">APROBACIONES</th>
                            <th style="font-size: 10px;">RADICADO</th>
                            <th style="font-size: 10px;">ACCIONES</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($soliAprobadas as $credito)
                        <tr>
                            <td style="font-size: 14px;">{{$credito->id}}</td>
                            <td style="font-size: 14px;">{{$credito->Nombre_Empresa_Persona}}</td>
                            <td style="font-size: 14px;">{{$credito->Nit}}</td>
                         
                            <td style="font-size: 14px;">{{number_format($credito->Monto_Solicitado)}}</td>
                            <td style="font-size: 14px;">{{$credito->Plazo_Credito_Meses}}</td>
                            <td style="font-size: 10px;" class="documentos" style="width:50px;">
                                <div class="dropdown" onclick="toggleDropdown(this)">
                                    <button class="btn btn-custom" type="button">
                                        <i class="fas fa-file"></i> Documentos
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ([
                                        'Documento_Consentimiento_inf' => 'Consentimiento',
                                        'Documento_Certificado_Bancario' => 'Certificado Bancario',
                                        'Documento_Referencia_Comercial' => 'Referencia Comercial',
                                        'Documento_Cedula' => 'Cédula',
                                        'Documento_Rut' => 'RUT',
                                        'Documento_Camara_Comercio' => 'Cámara de Comercio',
                                        'Documento_Declaracion_Renta' => 'Declaración de Renta',
                                        ] as $documento => $label)
                                        @if ($credito->$documento)
                                        <a class="dropdown-item" href="{{ url('/descargar-archivo/' . basename($credito->$documento)) }}" target="_blank">
                                            <i class="fas fa-download"></i> {{ $label }}
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/ver-documento/' . basename($credito->$documento)) }}" target="_blank">
                                            <i class="fas fa-eye"></i> Previsualizar {{ $label }}
                                        </a>
                                        @endif
                                        @endforeach

                                        @if (
                                        !$credito->Documento_Consentimiento_inf &&
                                        !$credito->Documento_Certificado_Bancario &&
                                        !$credito->Documento_Referencia_Comercial &&
                                        !$credito->Documento_Cedula &&
                                        !$credito->Documento_Rut &&
                                        !$credito->Documento_Camara_Comercio &&
                                        !$credito->Documento_Declaracion_Renta
                                        )
                                        <!-- Mostrar un mensaje si ninguno de los archivos existe -->
                                        <span class="dropdown-item text-danger">El archivo no está disponible</span>
                                        @endif
                                    </div>
                                </div>

                            </td>
                            <td style="font-size: 13px;" class="documentos" style="width:50px;">
                                <div class="dropdown" onclick="toggleDropdown(this)">
                                    <button class="btn btn-custom" type="button">
                                        <i class="fas fa-file"></i>Cartera
                                    </button>

                                    <div class="dropdown-menu">
                                        @foreach ([
                                        'Documento_informa_Cartera' => 'Informe de Informa',
                                        'Documento_data_credito' => 'Informe Datacrédito',

                                        ] as $documento => $label)
                                        @if ($credito->$documento)
                                        <a class="dropdown-item" href="{{ url('/descargar-archivo/cartera/' . basename($credito->$documento)) }}" target="_blank">
                                            <i class="fas fa-download"></i> {{ $label }}
                                        </a>
                                        <a class="dropdown-item" href="{{ url('/ver-documento/cartera/' . basename($credito->$documento)) }}" target="_blank">
                                            <i class="fas fa-eye"></i> Previsualizar {{ $label }}
                                        </a>
                                        @endif
                                        @endforeach

                                        @if (
                                        !$credito->Documento_informa_Cartera &&
                                        !$credito->Documento_data_credito
                                        )
                                        <!-- Mostrar un mensaje si ninguno de los archivos existe -->
                                        <span class="dropdown-item text-danger">El archivo no está disponible</span>
                                        @endif

                                    </div>
                                </div>

                            </td>


                            <td class="timeline-cell">

                                <div class="timeline-item">
                                    <div class="timeline-circle {{ $credito->Estado_Sagrilaft === 'Aprobado' ? 'approved' : ($credito->Estado_Sagrilaft === 'Rechazado' ? 'rejected' : '') }}">
                                        <span class="circle-inner"></span>
                                    </div>
                                    <div class="timeline-content">Aprobación Sagrilaft</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-circle {{ $credito->Estado_Cartera === 'Aprobado' ? 'approved' : ($credito->Estado_Cartera === 'Rechazado' ? 'rejected' : '') }}">
                                        <span class="circle-inner"></span>
                                    </div>
                                    <div class="timeline-content">Aprobado cartera</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-circle {{ $credito->Estado_Beratung === 'Aprobado' ? 'approved' : ($credito->Estado_Beratung === 'Rechazado' ? 'rejected' : '') }}">
                                        <span class="circle-inner"></span>
                                    </div>
                                    <div class="timeline-content">Aprobación Financiero</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-circle {{ $credito->Estado_Gerencia === 'Aprobado' ? 'approved' : ($credito->Estado_Gerencia === 'Rechazado' ? 'rejected' : '') }}">
                                        <span class="circle-inner"></span>
                                    </div>
                                    <div class="timeline-content" style="font-size: 12px;">Aprobación Gerencia</div>
                                </div>



                            </td>
                          
                            <!-- <td style="font-size: 14px;">{{$credito->Aceptacion_Politica_Datos_Personales}}</td> -->
                            <td style="font-size: 14px;">{{$credito->radicado}}</td>
                            <td>
                                @if(auth()->check() && auth()->user()->hasRole('cartera'))
                                @if($credito->Estado_Cartera === 'Pendiente')
                                <button type="button" class="btn-success aprobar-btn" onclick="aprobarCartera({{ $credito->id }})">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                @endif


                                <!-- Botón para aprobar Beratung -->
                                @if (auth()->check() && auth()->user()->hasRole('beratung'))
                                @if ($credito->Estado_Beratung === 'Pendiente')
                                <button type="button" class="btn btn-success" onclick="aprobarBeratung({{ $credito->id }})">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                @endif



                                @if (auth()->check() && auth()->user()->hasRole('sagrilaft'))
                                @if ($credito->Estado_Sagrilaft === 'Pendiente')
                                <button type="button" class="btn  btn-success" onclick="aprobarSagrilaft({{ $credito->id }})">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                @endif




                                @if (auth()->check() && auth()->user()->hasRole('cartera'))
                                @if ($credito->Estado_Cartera === 'Pendiente')
                                <button type="button" class="btn  btn-danger" onclick="rechazarCartera({{ $credito->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                                @endif

                                @if (auth()->check() && auth()->user()->hasRole('beratung'))
                                @if ($credito->Estado_Beratung === 'Pendiente')
                                <button type="button" class="btn btn-sm btn-danger" onclick="rechazarBeratung({{ $credito->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                                @endif

                                @if (auth()->check() && auth()->user()->hasRole('sagrilaft'))
                                @if ($credito->Estado_Sagrilaft === 'Pendiente')
                                <button type="button" class="btn btn-sm btn-danger" onclick="rechazarSagrilaft({{ $credito->id }})">
                                    <i class="fas fa-times"></i>
                                </button>

                                @endif
                                @endif

                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#comentarioModal{{ $credito->id }}" data-solicitud-id="{{ $credito->id }}">
                            <i class="fas fa-comment"></i>
                        </button> -->

                                <button type="button" class="btn btn-primary" onclick="verComentarios({{ $credito->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>


                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editarModal{{ $credito->id }}">

                                    <i class="fas fa-edit"></i>
                                </button>

                            </td>
                        </tr>

                        <!-- Modal específico para esta solicitud de crédito -->
                        <div class="modal fade" id="comentarioModal{{ $credito->id }}" tabindex="-1" role="dialog" aria-labelledby="comentarioModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #004170;">
                                        <h5 class="modal-title" id="comentarioModalLabel" style="color: #fff; ">Agregar
                                            Comentario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para agregar comentario -->
                                        <form>
                                            <div class="form-group">
                                                <label for="comentario">Comentario:</label>
                                                <textarea class="form-control" id="comentario{{ $credito->id }}" name="comentario" rows="4" required></textarea>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="agregarComentario({{ $credito->id }})">Guardar Comentario</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal para la edición -->
                        <!-- Modal para la edición -->
                        <div class="modal fade" id="editarModal{{ $credito->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #004170;">
                                        <h5 class="modal-title" id="editarModalLabel" style="color: #fff; ">Editar Monto
                                            Solicitado</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para editar el Monto Solicitado -->
                                        <form id="editarForm{{ $credito->id }}" action="{{ url('api/solicitud/actualizar', ['id' => $credito->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="monto">Nuevo Monto Solicitado:</label>
                                                <input type="number" class="form-control" id="monto{{ $credito->id }}" name="monto" value="{{ $credito->Monto_Solicitado }}" required>
                                                <br>

                                                <div class="form-group">
                                                    <label for="plazo" class="label-text">Plazo de Crédito:</label>
                                                    <select class="form-control custom-input" id="plazo" name="Plazo_Credito_Meses" id="Plazo_Credito_Meses{{ $credito->id }}">
                                                        <option value="{{ $credito->Plazo_Credito_Meses }}">
                                                            {{ $credito->Plazo_Credito_Meses }}
                                                        </option>
                                                        <option value="15">15 días</option>
                                                        <option value="30">30 días</option>
                                                        <option value="45">45 días</option>
                                                    </select>
                                                </div>




                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                Guardar Cambios y enviar correo al cliente <i class="fas fa-paper-plane"></i>
                                            </button>


                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <!-- Modal para mostrar los comentarios -->
                        <div class="modal fade" id="verComentariosModal" tabindex="-1" role="dialog" aria-labelledby="verComentariosModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <!-- Modal más grande para mostrar comentarios -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="verComentariosModalLabel">Comentarios de la Solicitud de
                                            Crédito</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul id="comentariosList" class="comment-list">

                                        </ul>
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

        </div>

    </div>
</div>



@endsection

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    function verComentarios(idSolicitud) {
        const url = `{{ url('api/solicitudes/obtener-comentarios') }}/${idSolicitud}`;

        axios.get(url)
            .then(response => {
                if (response.status === 200 && response.data.comentarios) {
                    const comentariosList = document.getElementById('comentariosList');
                    comentariosList.innerHTML = '';

                    response.data.comentarios.forEach(comentario => {
                        const comentarioItem = document.createElement('li');
                        comentarioItem.innerHTML =
                            `<strong>${comentario.user.name}:</strong> ${comentario.comentario}`;
                        comentariosList.appendChild(comentarioItem);
                    });

                    // Mostrar el modal de comentarios
                    $('#verComentariosModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar los comentarios.',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al cargar los comentarios.',
                });
            });
    }
</script>

<script>
    function agregarComentario(idSolicitud) {
        const url =
            `{{ url('api/comentariossolicitudescredito', ['id_solicitud' => '']) }}/${idSolicitud}`; // Usar idSolicitud en lugar de $credito->id
        const csrfToken = '{{ csrf_token() }}';
        const comentario = $('#comentario' + idSolicitud).val();

        axios.post(url, {
                comentario: comentario
            }, {
                headers: {
                    'X-CSRF-Token': csrfToken,
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (response.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.data.message,
                    }).then(() => {
                        $('#comentarioModal' + idSolicitud).modal('hide'); // Cierra el modal
                        $('#comentario' + idSolicitud).val(''); // Limpia el campo de comentario
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.data.message, // Muestra el mensaje de error del servidor
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al agregar el comentario.',
                });
            });
    }
</script>

<script>
    function aprobarCartera(creditoId) {
        // Mostrar la capa de carga
        document.getElementById('loading-overlay').style.display = 'block';

        const url = `{{ url('api/solicitudes/aprobar/cartera') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            // Ocultar la capa de carga
            document.getElementById('loading-overlay').style.display = 'none';

            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else {
                    // Aquí se muestra el icono de éxito en la alerta
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '', // Deja el texto vacío o personaliza según tu necesidad
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error al aprobar la solicitud de crédito.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>


<script>
    function aprobargerencia(creditoId) {
        // Mostrar la capa de carga
        document.getElementById('loading-overlay').style.display = 'block';

        const url = `{{ url('api/solicitudes/aprobar/gerencia') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            // Ocultar la capa de carga
            document.getElementById('loading-overlay').style.display = 'none';

            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else {
                    // Aquí se muestra el icono de éxito en la alerta
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '', // Deja el texto vacío o personaliza según tu necesidad
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error al aprobar la solicitud de crédito.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>

<script>
    function aprobarBeratung(creditoId) {
        const url = `{{ url('api/solicitudes/aprobar/beratung') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-Token': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            })
            .then(response => {
                if (response.status === 200) {
                    return response.json();
                } else {
                    throw new Error('Error en la solicitud');
                }
            })
            .then(data => {
                if (data.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error,
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al aprobar la solicitud de Beratung.',
                });
            });
    }
</script>


<script>
    function aprobarSagrilaft(creditoId) {
        const url = `{{ url('api/solicitudes/aprobar/sagrilaft') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito en Sagrilaft',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Sagrilaft',
                        text: response.error,
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Sagrilaft',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Sagrilaft',
                        text: 'Ha ocurrido un error al aprobar en Sagrilaft.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>



<script>
    function rechazarCartera(creditoId) {
        const url = `{{ url('api/solicitudes/rechazar/cartera') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rechazo en Cartera Exitoso',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Cartera',
                        text: response.error,
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Cartera',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Cartera',
                        text: 'Ha ocurrido un error al rechazar en Cartera.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>


<script>
    function rechazarBeratung(creditoId) {
        const url = `{{ url('api/solicitudes/rechazar/beratung') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rechazo en Beratung Exitoso',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Beratung',
                        text: response.error,
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Beratung',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Beratung',
                        text: 'Ha ocurrido un error al rechazar en Beratung.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>


<script>
    function rechazarSagrilaft(creditoId) {
        const url = `{{ url('api/solicitudes/rechazar/sagrilaft') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rechazo en Sagrilaft Exitoso',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Sagrilaft',
                        text: response.error,
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Sagrilaft',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Sagrilaft',
                        text: 'Ha ocurrido un error al rechazar en Sagrilaft.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>

<script>
    function rechazargerencia(creditoId) {
        const url = `{{ url('api/solicitudes/rechazar/gerencia') }}/${creditoId}`;
        const csrfToken = '{{ csrf_token() }}';

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Respuesta exitosa del servidor
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rechazo en Gerencia Exitoso',
                        text: response.message,
                    }).then(() => {
                        window.location.reload(); // Recargar la página u otra acción
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Sagrilaft',
                        text: response.error,
                    });
                }
            } else {
                // Respuesta de error del servidor
                const response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Sagrilaft',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Rechazo de Sagrilaft',
                        text: 'Ha ocurrido un error al rechazar en Sagrilaft.',
                    });
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }
</script>

<script>
    // Conecta al servicio de Pusher
    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        encrypted: true,
    });

    // Función para generar botones HTML según el rol del usuario y el estado de la solicitud
    function generateButtons(userRole, solicitudCredito) {
        let buttonsHtml = '';

        if (userRole === 'cartera' && solicitudCredito.Estado_Cartera === 'Pendiente') {
            buttonsHtml += `
            <form action="/api/solicitudes/aprobar/cartera/${solicitudCredito.id}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-sm btn-success aprobar-btn"><i class="fas fa-check"></i> Aprobar Cartera</button>
            </form>
            <form action="/api/solicitudes/rechazar/cartera/${solicitudCredito.id}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Rechazar Cartera</button>
            </form>
        `;
        }
        return buttonsHtml;
    }

    // Suscríbete al canal 'soli-credit' (debe coincidir con el que definiste en el evento)
    const channel = pusher.subscribe('soli-credit');

    // Escucha el evento 'NuevaSolicitudCreditoEvent'
    channel.bind('App\\Events\\NuevaSolicitudCreditoEvent', function(data) {
        // Crea una nueva fila en la tabla con los datos del evento

        // Muestra la notificación en tiempo real
        const notificationContent = document.getElementById('notification-content');
        notificationContent.textContent =
            `Nueva solicitud de crédito: ${data.solicitudCredito.Nombre_Empresa_Persona}`;

        // Muestra la fila de notificación en tiempo real
        const realTimeNotification = document.getElementById('real-time-notification');
        realTimeNotification.style.display = 'block';
    });
</script>
<script>
    // Función para mostrar la notificación en tiempo real
    function showRealTimeNotification(content) {
        const notificationContent = document.getElementById('notification-content');
        notificationContent.textContent = content;

        // Mostrar la notificación
        const notificationBox = document.getElementById('real-time-notification');
        notificationBox.style.animation = 'slide-in 0.5s ease-in-out forwards';

        // Reproducir el sonido de notificación
        const notificationSound = document.getElementById('notification-sound');
        notificationSound.play();
    }

    // Función para cerrar la notificación en tiempo real
    function closeRealTimeNotification() {
        const notificationBox = document.getElementById('real-time-notification');
        notificationBox.style.animation = 'slide-out 0.5s ease-in-out forwards';

        // Ocultar la notificación después de la animación
        setTimeout(() => {
            notificationBox.style.display = 'none';
        }, 500); // 500 milisegundos (0.5 segundos) para coincidir con la duración de la animación
    }

    // Ejemplo de uso cuando llega una notificación en tiempo real
    const data = "Nueva solicitud de crédito recibida";
    showRealTimeNotification(data);
</script>
<script>
    function toggleDropdown(element) {
        element.classList.toggle('active');
    }
</script>













