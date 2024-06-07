@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="#">GESTIÓN DE CARTERA</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">




                                <li class="nav-item dropdown">

                                    <a class="nav-link dropdown-toggle" href="#" id="carteraDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-chart-bar"></i> Créditos
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{url('Solicitudes-creditos')}}">Nuevas Solicitudes</a>
                                        <a class="dropdown-item" href="{{url('Solicitudes-creditos-rechazadas')}}">Solicitudes Rechazadas
                                        </a>
                                        <a class="dropdown-item" href="{{url('Solicitudes-creditos-aprobadas')}}">Solicitudes Aprobadas
                                        </a>



                                    </div>

                                </li>



                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Cartera Clientes
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{url('Gestion-Cartera')}}">Gestión de cartera
                                        </a>
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



                <section class="container-fluid">






                    <div id="respuestaEnVista"></div>



                    <div class="input-group mb-4">
                        <button class="btn btn-primary mt-3 me-2" id="btnGenerarCartera">Ejecutar Asistente Cartera</button>
                        <button class="btn btn-secondary mt-3 ml-2" id="">Enviar notificación Masiva</button>
                    </div>

                    <ul class="nav nav-tabs">

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Costo-No-Calidad.index')}}">SEGUIMIENTOS NOTA CRÉDITO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('CNC-COSTEADOS')}}">SEGUIMIENTOS CANCELADO</a>
                        </li>
                        @if(auth()->user()->can('Registrar_costonocalidad'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Coso-No-Calidad.create')}}">SEGUIMIENTOS CRITICO</a>
                        </li>
                        @endif
                        @if(auth()->user()->can('Export_Costos_No_Calidad'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Costo-No-Calidad.Indicadores')}}">SEGUIMIENTOS PROXIMA SEMANA</a>
                        </li>
                        @endif
                      
                    </ul>
                    <BR>
                    <section>

                        <table class="table table-bordered table-striped" id="datatable">
                            <thead class="table-dark">
                                <tr>
                                    <th style="font-size: 10px; width: 20px;">
                                        <input type="checkbox" id="selectAll" style="transform: scale(0.8);" class="form-control" />
                                    </th>
                                    <th style="font-size: 10px;">Documento</th>
                                    <th style="font-size: 10px;">Fecha Documento</th>
                                    <th style="font-size: 10px;">Fecha de Vencimiento</th>
                                    <th style="font-size: 10px;">Código Cliente</th>
                                    <th style="font-size: 10px;">Nombre Cliente</th>
                                    <th style="font-size: 10px;">Nombre Vendedor</th>
                                    <th style="font-size: 10px;">Estado</th>
                                    <th style="font-size: 10px;">Total Documento</th>
                                    <th style="font-size: 10px;">Pagado Hasta la Fecha</th>
                                    <th style="font-size: 10px;">Saldo Pendiente</th>
                                    <th style="font-size: 10px;">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cuentasporpa as $cuenta)
                                <tr>
                                    <td style="width: 20px;">
                                        <input type="checkbox" class="form-control bg-3" style="transform: scale(0.8);" name="selectedItems[]" />
                                    </td>
                                    <td style="font-size: 10px;">{{ $cuenta->documento }}</td>
                                    <td style="font-size: 10px;">{{ $cuenta->Fecha_Documento }}</td>
                                    <td style="font-size: 10px;">{{ $cuenta->Fecha_Vencimiento }}</td>
                                    <td style="font-size: 10px;">{{ $cuenta->Codigo_cliente }}</td>
                                    <td style="font-size: 10px;">{{ $cuenta->Nombre_Cliente }}</td>
                                    <td style="font-size: 10px;">{{ $cuenta->Vendedor }}</td>
                                    <td style="font-size: 10px;">{{ $cuenta->Estado_Documento }}</td>
                                    <td style="font-size: 10px;">{{ number_format($cuenta->Total_Documento) }}</td>
                                    <td style="font-size: 10px;">{{ number_format($cuenta->pagado_hasta_la_fecha) }}</td>
                                    <td style="font-size: 10px;">{{ number_format($cuenta->Saldo_Pendiente) }}</td>
                                    <td style="font-size: 10px;">
                                        <form>
                                            @csrf
                                            @method('PUT')
                                            <a class="btn btn-sm btn-success btn-editar" href="#" data-id="{{ $cuenta->id }}">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-info" href="#">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
            </div>
            </section>
            <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #004170; color:#fff">
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
            <div id="loading-overlays" class="loading-overlay">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-pulse"></i>
                    <span>Ejecutando operación...</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection





<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
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
    // Función para limpiar los campos del formulario
    function limpiarFormulario() {
        $('#formSeguimiento')[0].reset();
    }

    // Script para abrir el modal cuando se hace clic en el botón de editar
    $(document).ready(function() {
        $('.btn-editar').click(function() {
            // Obtén el ID de la cuenta específica al hacer clic en el botón de editar
            const idCuenta = $(this).data('id');
            $('#editarModal').modal('show');

            // Asigna el ID de la cuenta al formulario
            $('#formSeguimiento').data('idCuenta', idCuenta);

            // Limpia el formulario cada vez que se abre el modal
            limpiarFormulario();
        });

        $('#formSeguimiento').submit(function(e) {
            e.preventDefault(); // Evita el envío estándar del formulario

            const formData = $(this).serialize(); // Serializa los datos del formulario

            // Obtiene el ID de la cuenta almacenado en el formulario
            const idCuenta = $('#formSeguimiento').data('idCuenta');
            const url = `/api/gerarseguimiento_cuentasporpagar/${idCuenta}`;

            axios.post(url, formData, {
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                })
                .then(response => {
                    // Muestra la respuesta con SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.data.message,
                    }).then(() => {
                        // Cierra el modal después de que el usuario hace clic en "OK"
                        $('#editarModal').modal('hide');
                        // Limpia el formulario
                        limpiarFormulario();
                    });

                    // Puedes hacer más cosas con la respuesta, como actualizar la interfaz gráfica
                    console.log(response.data);
                })
                .catch(error => {
                    // Muestra el error con SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al enviar la solicitud: ' + JSON.stringify(error.response.data),
                    });
                    console.error('Error al enviar la solicitud:', error);
                });
        });
    });
</script>






<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("btnGenerarCartera").addEventListener("click", function() {
            // Muestra el elemento de carga al hacer clic en el botón
            $("#loading-overlays").show();

            fetch('/api/cuentas-porpagar', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // ... Tu lógica para mostrar los datos en la tabla

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