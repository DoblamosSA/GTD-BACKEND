

//select 2
$(document).ready(function() {
    $('#pais_id').select2();
});

$(document).ready(function() {
    $('#Asesor_id').select2();
});

$(document).ready(function() {
    $('#Departamento').select2();
});

//fin select2

//se consulta el cliente en sap mediante ajax y devuelve la respuesta a la vista en la tabla  para la vista create
$(document).ready(function() {
    $('#buscarClienteForm').on('submit', function(e) {
        e.preventDefault();
        var cliente = $('#cliente').val();
        buscarCliente(cliente);
    });

    function buscarCliente(cliente) {
        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/buscar-cliente-SAP-Prueba',
            type: 'GET',
            data: {
                cliente: cliente
            },
            success: function(response) {
                // Manejar la respuesta exitosa de la solicitud Ajax
                console.log(response); // Verificar la respuesta de la API
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

        // Verificar si se obtuvo un cliente válido
        if (clientes.hasOwnProperty('error')) {
            // No se encontró un cliente válido en SAP
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: clientes.error,
                confirmButtonText: 'OK',
                timer: 4000,
                timerProgressBar: true
            });
        } else if (clientes.hasOwnProperty('cliente')) {
            var cliente = clientes.cliente;
            var clienteId = clientes.clienteId;

            var fila = '<tr>' +
                '<td>' + cliente.CardCode + '</td>' +
                '<td>' + cliente.CardName + '</td>' +
                '<td>' + cliente.Phone1 + '</td>' +
                '</tr>';

            tablaResultados.find('tbody').append(fila);

            // Agregar el ID del cliente al input clientes_id
            $('#clientes_id').val(clienteId);
        } else {
            // No se encontró ningún cliente en SAP

            console.log(clientes);
        }
    }
});

//