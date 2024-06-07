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
        <h2 style="color: #004170;">Estado de Cuenta saldos pendientes - DOBLAMOS S.A</h2>
        <p>Cordial saludo estimado cliente,</p>
        <p>Nos dirigimos a usted para solicitar información acerca del estado de pago de las siguientes facturas, las cuales actualmente se encuentran vencidas:</p>

        <table class="responsive">
            <thead>
                <tr>
                    <th>FACTURA</th>
                    <th>FECHA DOCUMENTO</th>
                    <th>FECHA VENCIMIENTO</th>
                    <th>DÍAS VENCIDOS</th>
                    <th>NIT</th>
                    <th>CLIENTE</th>
                    <th>TOTAL FACTURA</th>
                    <th>PAGO A LA FECHA</th>
                    <th>SALDO PENDIENTE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $cuenta)
                <tr>
                    <td>{{ $cuenta->documento }}</td>
                    <td>{{ $cuenta->Fecha_Documento }}</td>
                    <td>{{ $cuenta->Fecha_Vencimiento }}</td>
                    <td>{{ $cuenta->Dias_Vencidos }}</td>
                    <td>{{ $cuenta->Codigo_cliente }}</td>
                    <td>{{ $cuenta->Nombre_Cliente }}</td>
                    <td>${{ number_format($cuenta->Total_Documento, 2) }}</td>
                    <td>${{ number_format($cuenta->pagado_hasta_la_fecha, 2) }}</td>
                    <td>${{ number_format($cuenta->Saldo_Pendiente, 2) }}</td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="8" style="text-align: right; font-weight: bold; ">Total Pendiente:</td>
                    <td style="background-color:#FBFBD2">${{ number_format($sumaSaldoPendiente, 2) }}</td>
                </tr>

            </tbody>
        </table>

        <p><strong>Agradeceríamos mucho que nos proporcionara detalles sobre los pagos realizados en relación con alguna o todas estas facturas. En caso de haber realizado los pagos correspondientes, le agradeceríamos si pudiera compartir el soporte de pago correspondiente. Esta colaboración nos permitirá mantener actualizada nuestra cartera y garantizar una gestión eficiente de los registros financieros.</strong></p>
        <p>En caso de presentar alguna mora, por favor informar al siguiente correo: <strong style="color: #004170;">analista.cartera@doblamos.com</strong>. Si ya realizó el desembolso o tiene alguna novedad, por favor enviar el soporte o notificar al correo <strong style="color: #004170;">elkin.gutierrez@doblamos.com</strong>.</p>

        <p>Muchas gracias.</p>
    </div>

    <div class="footer">
        <p>NOTA: Este correo electrónico ha sido generado automáticamente por el sistema. No responda a este mensaje. Para cualquier pregunta o inquietud, contáctenos al número de celular 3102547014.</p>
    </div>
</body>


</html>