@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')
<br>
<style>
    .btn-estado {
        width: 150px;
  
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('SEGUIMIENTO COTIZACIONES ESTRUCTURAS METALICAS') }}
                        </span>
                    </div>
                </div>

                <br>
                <div class="d-md-flex justify-content-md-end">
                    <div class="col">


                        @if(auth()->user()->can('Estructuras_Exportar_Cotizacion'))
                        <a href="{{route('estructurasMetalicas.export')}}" class="btn  btn-success"><i class="fas fa-file-export"></i> Exportar Excel

                        </a>
                        @endif


                        @if(auth()->user()->can('Estructuras_Generar_Cotizacion'))
                        <a href="{{route('estructurasMetalicas.create')}}" class="btn btn-primary"><i></i>
                            Crear Nuevo
                        </a>
                        @endif


                        @if(auth()->user()->can('Estructuras_Indicadores'))
                        <a href="" class="btn btn-warning"><i></i> Indicadores
                        </a>
                        @endif

                    </div>


                </div>
                <br>
                @if ($errors->any())
                <div class="alert alert-danger">

                    <p>Corrige los siguientes errores: El cliente no se guardo correctamente</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Clientes Doblamos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="modal-body">

                                <form action="" method="post">

                                    @csrf
                                    <fieldset>
                                        <legend class="text-center header"> Registro Clientes</legend>

                                        <div class="form-group">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                                            <div class="col-md-12">
                                                <input name="Empresa" type="text" placeholder="Empresa" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Nit" type="text" placeholder="Nit" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Contacto" type="text" placeholder="Contacto" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-envelope-o bigicon"></i></span>
                                            <div class="col-md-12">
                                                <input name="Correo" type="text" placeholder="Correo" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <input name="Telefono" type="text" placeholder="Telefono" class="form-control">
                                            </div>
                                        </div>

                                        <div class="box-footer mt20">
                                            <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                        </div>
                                        <br>
                                    </fieldset>
                                </form>



                            </div>

                        </div>
                    </div>
                </div>



                <table class="table table-bordered table-striped" id="datatableinfo">
                    <thead>
                        <tr>

                            <th>Cliente</th>
                            <th>Nombres</th>
                            <th>Telefono</th>
                            <th>#Obra</th>
                            <th>Nombre Obra</th>
                            <th>Lugar Obra</th>
                            <th>Fecha Recibido</th>
                            <th>Fecha Cotizada</th>
                            <th>Valor A.Iva</th>
                            <th>Valor Adjudicado</th>
                            <th>Tipologia</th>
                            <th>Estado</th>
                            <th>Peso Cotizado</th>
                            <th>Area Cotizada</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($estructuraMelalica as $row)
                        <tr>

                            <td>{{$row->clientes->CardCode}}</td>
                            <td>{{$row->clientes->CardName}}</td>
                            <td>{{$row->clientes->Phone1}}</td>
                            <td>{{$row->Numero_Obra}}</td>
                            <td>{{$row->Nombre_Obra}}</td>
                            <td>{{$row->Lugar_Obra}}</td>
                            <td>{{$row->Fecha_Recibido}}</td>
                            <td>{{$row->Fecha_Cotizada}}</td>
                            <td>${{number_format($row->Valor_Antes_Iva)}} </td>
                            <td>${{number_format($row->Valor_Adjudicado)}}</td>
                            <td>{{$row->Tipologia}}</td>
                            @if($row->Estado == 'Perdida')
                            <td class="btn btn-danger btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'Seguimiento')
                            <td class="btn btn-sm btn-danger bg-warning btn-estado"> {{$row->Estado}}</td>
                            @elseif($row->Estado == 'Vendida')
                            <td class="btn btn-sm btn-success btn-estado"> {{$row->Estado}}</td>
                            @elseif($row->Estado == 'Pendiente')
                            <td class="btn btn-sm btn-danger btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'Cerrada')
                            <td class="btn btn-light btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'Adjudicada')
                            <td class="btn btn-light btn-estado">{{$row->Estado}}</td>
                            @elseif($row->Estado == 'No cotizada')
                            <td class="btn btn-light btn-estado">{{$row->Estado}}</td>
                            @endif
                            <td>Kg {{$row->Peso_Cotizado}}</td>
                            <td>{{$row->Area_Cotizada}}</td>
                            </td>



                            <td>

                                <a class="btn btn-sm btn-success" href="{{route('estructurasMetalicas.edit',$row->id)}}"><i class="fa fa-fw fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-primary btn-seguimiento" data-toggle="modal" data-target="#editarModal" data-id="{{ $row->id }}" title="Seguimientos" onclick="agregarID('{{ $row->id }}')">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                                <button type="button" class="btn btn-outline-info" onclick="verComentarios({{ $row->id }})" title="Comentarios del seguimiento">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <!-- <button type="submit" class="btn btn-danger btn-sm "><i class="fa fa-fw fa-trash"></i></button> -->

                            </td>


                        </tr>

                        @endforeach

                    </tbody>
                </table>
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

                                    <input type="hidden" id="idseguimiento" name="idseguimiento">
                                 
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <p>ID seleccionado: <span id="idSeleccionado"></span></p>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Fecha del seguimiento</span>
                                        <input type="date" name="Fecha_Seguimiento" class="form-control">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Fecha próximo seguimiento</span>
                                        <input type="date" name="Fecha_Nuevo_Seguimiento" class="form-control">
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon2">Eventos</span>
                                        <select class="form-control" name="Evento">
                                            <option value=""></option>
                                            <option value="Visita cliente">Visita cliente</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Pagina web">Página web</option>
                                            <option value="Valla">Valla</option>
                                            <option value="Referido">Referido</option>
                                            <option value="Cliente actual">Cliente actual</option>
                                            <option value="Distribuidor">Distribuidor</option>
                                            <option value="Ideo">Ideo</option>
                                            <option value="Asesor">Asesor</option>
                                        </select>
                                    </div>

                                    <br>

                                    <div class="input-group">
                                        <span class="input-group-text">Comentarios</span>
                                        <textarea class="form-control" name="Observaciones" aria-label="With textarea"></textarea>
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
                                <h5 class="modal-title" id="verComentariosModalLabel">Seguimientos cotizaciones</h5>
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
                                            <th>Evento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="comentariosTableBody">

                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function agregarID(id) {
        document.getElementById('idseguimiento').value = id;
        document.getElementById('idSeleccionado').textContent = id;
    }
</script>
<script>
    $(document).ready(function() {
        function limpiarFormulario() {
            $('#formSeguimiento')[0].reset();
        }

        $('.btn-editar').click(function() {
            const idseguimiento = $(this).data('id');
            if (idseguimiento) {
                abrirModal(idseguimiento);
                limpiarFormulario();
            } else {
                console.error('ID de seguimiento no válido.');
            }
        });

        function abrirModal(idseguimiento) {
            var screenWidth = window.screen.availWidth;
            console.log('Ancho de la pantalla disponible:', screenWidth);

            if (screenWidth <= 90) {
                $('#editarModal').modal('show');
                $('#idseguimiento').val(idseguimiento); // Establecer el ID en el campo oculto del formulario
                $('#idSeleccionado').text(idseguimiento); // Mostrar el ID seleccionado en el modal
            }
        }

        $('#formSeguimiento').submit(function(e) {
            e.preventDefault();
            e.stopPropagation();

            const idseguimiento = $('#idseguimiento').val(); // Obtener el ID del campo oculto del formulario

            if (idseguimiento) {
                const formData = $(this).serialize();
                const url = `https://rdpd.sagerp.co:59881/gestioncalidad/public/api/Generar-seguimiento-estructuras/${idseguimiento}`;

                axios.post(url, formData, {
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}', // Token CSRF
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
                    })
                    .catch(error => {
                        if (error.response && error.response.status === 422) {
                            const errors = error.response.data.errors;
                            Object.keys(errors).forEach(field => {
                                const errorMessage = errors[field][0];
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
            } else {
                console.error('ID de seguimiento no válido.');
            }

            return false;
        });
    });
</script>
<script>
    function verComentarios(id_cuenta) {
        // Hacer la llamada AJAX
        $.ajax({
            url: `{{ url('https://rdpd.sagerp.co:59881/gestioncalidad/public/api/seguimientos-estructuras-obtener-comentarios') }}/${id_cuenta}`,
            type: 'GET',
            success: function(data) {
                // Limpiar el cuerpo de la tabla
                $('#comentariosTableBody').empty();

                // Iterar sobre los comentarios y agregarlos a la tabla
                $.each(data.seguimientos, function(index, seguimiento) {
                    $('#comentariosTableBody').append(
                        `<tr>
                                    <td>${seguimiento.id}</td>
                                    <td>${seguimiento.Fecha_Seguimiento}</td>
                                    <td>${seguimiento.Fecha_Nuevo_Seguimiento}</td>
                                    <td>${seguimiento.Observaciones}</td>
                                    <td>${seguimiento.Evento}</td>
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



@if (session('eliminar') == 'ok')
<script>
    swal.fire(
        'Eliminado!',
        'Seguimiento de la cotización eliminado Correctamente!',
        'success'
    )
</script>
@endif

<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();

        swal.fire({
            title: 'Estas seguro que deseas eliminar el seguimiento? ',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '3085d6',
            CancelButtonColor: '#d33',
            CancelButtonText: 'yes, delete it!'

        }).then((result) => {
            if (result.value) {
                this.submit();
            }

        })
    });
</script>

@endsection