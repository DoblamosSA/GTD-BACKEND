@extends('layouts.dashboard')

@section('content')


<style>
    .selected-row {
    background-color: #B8B6B4;
}
</style>
<link rel="stylesheet" href="{{ asset('css/MRP/mrp.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: #1c2a48;">

                    <div class="container">
                        <header class="py-2" style="text-align: center; ">
                            <h4><b style="color: #fff;">ABASTECIMIENTO MRP SAP</b></h4>
                        </header>

                    </div>

                </div>


                <section class="container-fluid">


                    <section class="inventory-section">


                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <label for="bodega">Bodega:</label>
                                <select class="form-control" name="bodega" id="bodega">
                                    <option selected disabled>Selecciona la bodega</option>
                                    <option value="RIONEGRO|PROMO Y REMASQUE RIONEGRO">Rionegro</option>
                                    <option value="LA 33|PROMO Y REMASQUE LA 33">La 33</option>
                                    <option value="COPACABANA|PROMO Y REMASQUE COPACABANA">Copacabana</option>
                                </select>
                            </div>




                            <div class="col-md-3 mb-3">
                                <label for="fecharequerida">Fecha Requerida:</label>
                                <input type="date" class="form-control" name="fecharequerida" id="fecharequerida">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="calcularSugerido">Calcular Sugerido:</label>
                                <select class="form-control" name="calcularSugerido" id="calcularSugerido">
                                    <option selected disabled>Selecciona</option>

                                    <option value="Si">Calcular Sugerido</option>
                                    <option value="No">No Calcular</option>
                                </select>
                            </div>


                        </div>
                    </section>



                    <div id="respuestaEnVista"></div>

                    <div class="input-group mb-4">
                        <button class="btn btn-primary mt-3 me-2" id="btnGenerarpromedioventa">Ejecutar Asistente MRP</button>
                        <button class="btn btn-secondary mt-3 ml-2" id="btnGenerarSolicitudCompra">Generar solicitud compra</button>
                    </div>

                    <div id="loading-overlays" class="loading-overlay">
                        <div class="loading-spinner">
                            <i class="fas fa-spinner fa-pulse"></i>
                            <span>Ejecutando MRP SAP...</span>
                        </div>
                    </div>

                    <section>

                        <div class="table-responsive" class="container-fluid">
                            <table id="datatable" class="table" style="width: 100%;">

                                <thead>
                                    <tr>

                                        <th style="font-size: 10px; width: 20px;">
                                            <input type="checkbox" id="selectAll" style="transform: scale(0.8);" class="form-control" />
                                        </th>

                                        <th style="font-size: 10px; width: 10%;">ARTICULO</th>

                                        <th style="font-size: 10px;">DESCRIPCIÓN</th>
                                        <th style="font-size: 10px;">PESO</th>
                                        <th style="font-size: 10px; width: 10%;">BODEGA</th>
                                        <th style="font-size: 10px; width: 10%;">STOCK</th>
                                        <th style="font-size: 10px; width: 10%;">COMPROMETIDO</th>
                                        <th style="font-size: 10px; width: 10%;">PEDIDO</th>
                                        <th style="font-size: 10px; width: 10%;">DISPONIBLE</th>
                                        <th style="font-size: 10px; width: 10%;">PROMEDIO VENTA</th>
                                        <th style="font-size: 10px; width: 10%;">SUGERIDO</th>
                                    </tr>
                                </thead>



                                <tbody>
                                    @foreach($abastecimientos as $abastecimiento)
                                    <tr @if($abastecimiento->existencia_arti_historial == 1) style="background-color: #ADD8E6;" @endif>
                                        <td style="width: 20px;">
                                            <input type="checkbox" class="form-control bg-3" style="transform: scale(0.8);" name="selectedItems[]" value="{{ $abastecimiento->id }}" />
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            <a href="#" class="article-link" data-item-code="{{ $abastecimiento->ItemCode }}">{{ $abastecimiento->ItemCode }}</a>
                                            <!-- Contenedor para la respuesta -->
                                            <div class="response-row" style="display: none;">
                                                <div class="response-containers"></div>
                                            </div>
                                        </td>
                                        <td class="align-middle" style="font-size: 10px; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $abastecimiento->Dscription }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->SWeight1 }}kg
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->Almacen }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->Stock }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->Comprometido }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->Pedido }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->Disponible }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            {{ $abastecimiento->Pventa }}
                                        </td>
                                        <td class="align-middle" style="font-size: 10px;">
                                            <input type="text" class="form-control" name="sugerido[]" value="{{ $abastecimiento->Sugerido }}" style="width: 80px;" />
                                        </td>
                                    </tr>
                           
                                </tbody>
                                @foreach($transferenciastock as $transferencia)
                                @if($abastecimiento->ItemCode == $transferencia->COD_ARTI)
                                <tr>
                                    <td colspan="14" style="background-color: #f0f0f0; padding: 5px 10px;">
                                        <table style="width: 100%; font-size: 11px; border-collapse: collapse;">
                                            <tr style="background-color: #b0b0b0; font-weight: bold;">
                                                <td>Solicitud de Traslado</td>
                                                <td>Código del Artículo</td>
                                                <td>Bodega Origen</td>
                                                <td>Bodega Tránsito</td>
                                                <td>Almacen Final</td>
                                                <td>Cantidad Traslado</td>
                                            </tr>
                                            <td style="padding: 5px; background-color: #e0e0e0;">{{ $transferencia->SOLICITUD_TRASLADO }}</td>
                                            <td style="padding: 5px; background-color: #e0e0e0;">{{ $transferencia->COD_ARTI }}</td>
                                            <td style="padding: 5px; background-color: #e0e0e0;">{{ $transferencia->BODEGA_ORIGEN }}</td>
                                            <td style="padding: 5px; background-color: #e0e0e0;">{{ $transferencia->BODEGA_TRANSITO }}</td>
                                            <td style="padding: 5px; background-color: #e0e0e0;">{{ $transferencia->ALMACEN_FINAL }}</td>
                                            <td style="padding: 5px; background-color: #1c2a48; color: white;">{{ $transferencia->CANTIDAD_TRASLADO }}</td>


                                        </table>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endforeach
                            </table>
                        </div>
                    </section>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Agrega un evento de cambio al checkbox "selectAll"
        document.getElementById("selectAll").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = document.getElementById("selectAll").checked;

                // Marcar o desmarcar la fila según el estado del checkbox
                toggleRowColor(checkbox);
            });
        });

        // Manejar el cambio de estado de los checkboxes individuales
        document.querySelectorAll('input[name="selectedItems[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Marcar o desmarcar la fila según el estado del checkbox
                toggleRowColor(this);
            });
        });

        // Función para cambiar el color de la fila
        function toggleRowColor(checkbox) {
            if (checkbox.checked) {
                checkbox.closest('tr').classList.add('selected-row');
            } else {
                checkbox.closest('tr').classList.remove('selected-row');
            }
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Manejar la lógica de selección de todos los checkboxes
        document.getElementById("selectAll").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = document.getElementById("selectAll").checked;
            });
        });

        // Manejar la lógica del botón "Asistente MRP"
        document.getElementById("btnGenerarpromedioventa").addEventListener("click", function() {
            // Verificar que se haya seleccionado una bodega
            var selectedBodega = document.querySelector('select[name="bodega"]').value;
            if (selectedBodega === "Selecciona la bodega") {
                Swal.fire({
                    title: 'Error',
                    text: 'Por favor, selecciona una bodega antes de ejecutar el MRP.',
                    icon: 'error',
                });
                return;
            }

            // Obtener valor seleccionado de "Calcular Sugerido"
            var calcularSugerido = document.querySelector('select[name="calcularSugerido"]').value;

            // Mostrar mensaje de confirmación con SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres ejecutar el MRP?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ejecutar MRP'
            }).then((result) => {
                // Si el usuario confirma, proceder con la lógica del MRP
                if (result.isConfirmed) {
                    // Mostrar indicador de carga
                    $("#loading-overlays").show();

                    // Realizar la solicitud fetch con el método POST y parámetros en el cuerpo
                    fetch('{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/consumirpromedioventaSAP', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Agregar token CSRF si es necesario
                            },
                            body: JSON.stringify({
                                bodega: selectedBodega,
                                calcularSugerido: calcularSugerido,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Ocultar indicador de carga
                            $("#loading-overlays").hide();

                            // Limpia el contenido actual de la tabla
                            $("#datatable tbody").empty();
                            // Recargar la página después de la ejecución
                           
                        })
                        .catch(error => {
                            // Ocultar indicador de carga en caso de error
                            $("#loading-overlays").hide();

                            console.error('Error en la solicitud:', error);
                        });
                }
            });
        });

    });

    // Manejar la lógica del botón "Generar solicitud compra"
    document.getElementById("btnGenerarSolicitudCompra").addEventListener("click", function() {
        // Verificar que se haya seleccionado una bodega
        var selectedBodega = document.querySelector('select[name="bodega"]').value;
        if (selectedBodega === "Selecciona la bodega") {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, selecciona una bodega antes de generar la solicitud de compra.',
                icon: 'error',
            });
            return;
        }

        // Mostrar mensaje de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Quieres generar la solicitud de compra en SAP?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, generar solicitud de compra'
        }).then((result) => {
            // Si el usuario confirma, proceder con la lógica de generación de solicitud de compra
            if (result.isConfirmed) {
                // Mostrar indicador de carga
                $("#loading-overlays").show();

                // Obtener valores de los campos de entrada
                var selectedItems = [];
                var sugeridos = [];


                var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]:checked');
                checkboxes.forEach(checkbox => {
                    selectedItems.push(checkbox.value);
                    // Obtener el valor de la cantidad del artículo correspondiente
                    var sugeridoInput = checkbox.closest('tr').querySelector('input[name="sugerido[]"]');
                    sugeridos.push(sugeridoInput.value);


                });

                // Obtener el valor de la bodega
                var bodega = document.querySelector('select[name="bodega"]').value;
                var fechaRequerida = document.getElementById('fecharequerida').value;

                // Realizar la solicitud fetch con el método POST y parámetros en el cuerpo
                fetch('{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/generar-solicitud-compra', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Agregar token CSRF si es necesario
                        },
                        body: JSON.stringify({
                            selectedItems: selectedItems,
                            sugeridos: sugeridos,
                            bodega: bodega,
                            fecharequerida: fechaRequerida,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Ocultar indicador de carga
                        $("#loading-overlays").hide();

                        if (data.error) {
                            // Construye un mensaje de error con detalles y muéstralo en tu vista
                            let errorMessage = `<div>${data.error}</div>`;
                            if (data.foundItemCodes) {
                                const errorDetails = data.foundItemCodes.map(itemCodeData => `ItemCode: ${itemCodeData.ItemCode}, DocNum: ${itemCodeData.DocNum}`).join('<br>');
                                errorMessage += `<div>${errorDetails}</div>`;
                            }

                            Swal.fire({
                                title: 'Error',
                                html: errorMessage,
                                icon: 'error',
                            });
                        } else if (data.success) {
                            // Operación exitosa
                            if (data.foundItemCodes) {
                                const docNums = data.foundItemCodes.map(itemCodeData => `ItemCode: ${itemCodeData.ItemCode}, DocNum: ${itemCodeData.DocNum}`).join('<br>');
                                Swal.fire({
                                    title: 'Éxito',
                                    html: `Solicitud de compra generada exitosamente en SAP. ${data.DocNum}`,
                                    icon: 'success',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {

                                Swal.fire({
                                    title: 'Éxito',
                                    text: `Solicitud de compra generada exitosamente en SAP. DocNum: ${data.DocNum}`,
                                    icon: 'success',
                                }).then(() => {
                                   
                                });
                            }
                        }
                    })

                    .catch(error => {
                        // Ocultar indicador de carga en caso de error
                        $("#loading-overlays").hide();

                        // Debug: Mostrar el error en la consola
                        console.log(error);

                        // Mostrar mensaje de error detallado con SweetAlert2
                        let errorMessage = 'Ocurrió un error al realizar la solicitud a SAP.';

                        if (error && error.response && error.response.data) {
                            errorMessage = `<div>${error.response.data.error.message.value}</div>`;
                        }

                        Swal.fire({
                            title: 'Error',
                            html: errorMessage,
                            icon: 'error',
                        }).then(() => {
                          
                        });
                    });


            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ...

        // Agregar evento de clic al enlace del artículo
        $('#datatable tbody').on('click', '.article-link', function(e) {
            e.preventDefault();

            // Obtener el valor del artículo del enlace
            var itemCode = $(this).data('item-code');

            // Obtener la fila actual
            var currentRow = $(this).closest('tr');

            // Ocultar todas las filas de respuesta anteriores
            $('.response-row').hide();

            // Buscar la última fila de respuesta después de la fila actual
            var responseRow = currentRow.nextAll('.response-row').first();

            // Si no hay una fila de respuesta, crea una nueva después de la fila actual
            if (!responseRow.length) {
                responseRow = $('<tr class="response-row"><td colspan="12"><div class="response-containers"><table class="response-table"></table></div></td></tr>');
                currentRow.after(responseRow);
            }

            // Obtener el contenedor de la tabla de respuesta en la fila de respuesta actual
            var responseTable = responseRow.find('.response-table');

            // Mostrar el spinner
            showLoadingOverlay('Consultando inventario en SAP...');

            // Realizar la solicitud Ajax con el método GET para enviar el valor a tu API
            $.ajax({
                url: '{{ env('APP_ENV') === 'production' ? env('URI_PROD') : env('URI_DEV') }}/api/consultar-stock-bodega-articuloSAP', // Asegúrate de actualizar la URL
                method: 'GET', // Cambia a 'POST' si es necesario
                data: {
                    codigoArticuloSAP: itemCode,
                },
                success: function(response) {
                    console.log(response); // Ver la respuesta en la consola

                    // Resto de tu lógica...
                    var itemCode = response[0]['ItemCode'];

                    var itemStock = response[0]['ItemStock'];

                    // Limpiar contenido anterior de la tabla
                    responseTable.empty();

                    // Crear encabezados de tabla
                    responseTable.append('<tr><th>Bodega</th><th>Stock</th><th>Pedido</th><th>Comprometido</th><th>Disponible</th></tr>');

                    // Ahora puedes iterar sobre itemStock y agregar filas a la tabla
                    itemStock.forEach(function(warehouseInfo) {
                        var warehouseCode = warehouseInfo['WarehouseCode'];
                        var inStock = warehouseInfo['InStock'];
                        var Ordered = warehouseInfo['Ordered'];
                        var Committed = warehouseInfo['Committed'];
                        var disponible = warehouseInfo['Disponible'];

                        // Agregar una fila a la tabla
                        responseTable.append('<tr><td>' + warehouseCode + '</td><td>' + inStock + ' UND</td><td>' + Ordered + '</td><td>' + Committed + '</td><td>' + disponible + '</td></tr>');

                        // Puedes personalizar la forma en que deseas mostrar la información en la tabla
                        // Puedes agregar más columnas, estilos, etc., según tus necesidades
                    });

                    // Ocultar el spinner
                    hideLoadingOverlay();

                    // Mostrar la fila de respuesta
                    responseRow.show();

                    // Resto de tu lógica...
                },
                error: function(error) {
                    console.error('Error en la solicitud:', error);

                    // Ocultar el spinner en caso de error
                    hideLoadingOverlay();
                }
            });
        });

        // ...

        // Función para mostrar el spinner con un mensaje
        function showLoadingOverlay(message) {
            $('#loading-overlays .loading-spinner span').text(message);
            $('#loading-overlays').show();
        }

        // Función para ocultar el spinner
        function hideLoadingOverlay() {
            $('#loading-overlays').hide();
        }
    });
</script>

@endsection