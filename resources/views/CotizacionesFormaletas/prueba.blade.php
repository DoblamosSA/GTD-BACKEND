@extends('layouts.dashboard')

@section('template_title')
Seguimiento Cotizaciones Estructura
@endsection



@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ __('Clientes Doblamos SAP') }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form id="buscarClienteForm" class="form-inline mb-3">
                        <div class="form-group mr-2">
                            <input type="text" class="form-control" id="cliente" name="cliente"
                                placeholder="Ingrese la cédula del cliente">
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>

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
                    </form>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{asset('js/Cotizaciones_Formaletas/cotizacionesFormaletas.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#buscarClienteForm').on('submit', function(e) {
            e.preventDefault();
            var cliente = $('#cliente').val();
            buscarCliente(cliente);
        });

        function buscarCliente(cliente) {
            $.ajax({
                url: '/buscar-cliente-SAP-Prueba',
                type: 'GET',
                data: {
                    cliente: cliente
                },
                success: function(response) {
                    // Manejar la respuesta exitosa de la solicitud Ajax
                    actualizarTablaResultados(response);
                },
                error: function(xhr) {
                    // Manejar el error de la solicitud Ajax
                    console.log(xhr.responseText);
                }
            });
        }

        function actualizarTablaResultados(clientes) {
            var tablaResultados = $('#tablaResultados');
            tablaResultados.find('tbody').empty();

            // Parsear la respuesta JSON
            var data = JSON.parse(clientes);

            // Verificar si se obtuvo un cliente válido
            if (data.hasOwnProperty('error')) {
                // No se encontró un cliente válido en SAP
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error,
                    confirmButtonText: 'OK',
                    timer: 4000,
                    timerProgressBar: true
                });
            } else if (data.hasOwnProperty('CardCode')) {
                var cliente = data;

                var fila = '<tr>' +
                    '<td>' + cliente.CardCode + '</td>' +
                    '<td>' + cliente.CardName + '</td>' +
                    '<td>' + cliente.Phone1 + '</td>' +
                    '</tr>';

                tablaResultados.find('tbody').append(fila);

                // Agregar el ID del cliente al input clientes_id
                $('#clientes_id').val(cliente.id);
            } else {
                // Otro error desconocido
                console.log(data);
            }
        }
    });
</script>



@endsection