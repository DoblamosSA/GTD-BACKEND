<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 20px rgba(0, 65, 112, 0.1);
            overflow-x: auto;
            /* Agregado para permitir desplazamiento horizontal en dispositivos pequeños */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #004170;
            color: white;
        }

        h2 {
            color: #004170;
        }

        p {
            margin: 10px 0;
        }

        .footer {
            margin-top: 20px;
            background-color: #004170;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
    <title>Estado de Cuenta</title>
</head>

<body>
    <div style="margin: 20px;">
        <h2 style="color: #004170;">Solicitud de compra - DOBLAMOS S.A</h2>
        <p>Cordial saludo,</p>
        <p>El usuario: {{ $solicitud->usuarioSolicitante->name }} realizó la siguiente solicitud de crédito:</p>

        <table class="responsive">
            <thead>
                <tr>
                    <th style="font-size: 9px;">ARTÍCULO</th>
                    <th style="font-size: 9px;">DESCRIPCIÓN</th>
                    <th style="font-size: 9px;">CANTIDAD</th>
                    <th style="font-size: 9px;">COMENTARIOS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($solicitud->detalleSolicitudes as $detalle)
                <tr>
                    <td style="font-size: 10px;">{{ $detalle->material->ItemCode }}</td>
                    <td style="font-size: 10px;">{{ $detalle->Descripcion }}</td>
                    <td style="font-size: 10px;">{{ $detalle->Cantidad }}</td>
                    <td style="font-size: 9.5px;">{{ $detalle->TextoLibre }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No hay detalles disponibles</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- <div style="margin-top: 20px;">
            <label for="comentariosAprobador" style="font-size: 10px;">Comentarios del Aprobador:</label>
            <textarea id="comentariosAprobador" name="comentariosAprobador" style="width: 100%; height: 100px; font-size: 10px;"></textarea>
        </div> -->

        <div style="margin-top: 20px;">
            <a href="https://rdpd.sagerp.co:59881/gestioncalidad/public/api/aprobar-solicitudcompragerencia/{{ $solicitud->id }}/{{ $idUsuarioAprobador }}" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; margin-right: 10px;" data-method="PUT">Aprobar</a>


            <a href="https://rdpd.sagerp.co:59881/gestioncalidad/public/api/rechazar-solicitudcompragerencia/{{ $solicitud->id }}/{{ $idUsuarioAprobador }}" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none;" data-method="PUT">Rechazar</a>
        </div>
    </div>

    <div class="footer">
        <p>Este correo electrónico ha sido generado automáticamente por el sistema GTD. No responder</p>
    </div>
</body>


</html>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">





<script>
    document.addEventListener('click', function(event) {
        var element = event.target;

        if (element.hasAttribute('data-method')) {
            event.preventDefault();

            var form = document.createElement('form');
            form.action = element.href;
            form.method = 'POST';
            form.style.display = 'none';

            var methodInput = document.createElement('input');
            methodInput.name = '_method';
            methodInput.value = element.getAttribute('data-method');
            form.appendChild(methodInput);

            document.body.appendChild(form);

            // Realizar una solicitud Ajax
            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(response => response.json())
                .then(data => {
                    // Manejar la respuesta del servidor
                    if (data.success) {
                        alert('Éxito: ' + data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud:', error);
                })
                .finally(() => {
                    // Eliminar el formulario después de la solicitud
                    document.body.removeChild(form);
                });
        }
    });
</script>