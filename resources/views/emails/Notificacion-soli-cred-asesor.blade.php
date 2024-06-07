<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación Solicitud de Crédito Doblamos S.A</title>
    <style>
    body {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    table {
        margin: 0 auto;
        width: 600px;
        background-color: #ffffff;
        border-collapse: collapse;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
    }

    td {
        padding: 20px;
        text-align: left;
    }

    td.header {
        background-color: #00417075;
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    h2 {
        font-size: 36px;
        margin: 0;
        color: #fff;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    ul li {
        margin-bottom: 10px;
    }

    strong {
        font-weight: bold;
        color: #333;
    }

    p.signature {
        font-style: italic;
        color: #555;
        font-size: 18px;
    }

    td.footer {
        background-color: #ff8800;
        color: #fff;
        text-align: center;
        padding: 10px 0;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    p.footer-text {
        font-size: 16px;
        margin: 0;
    }

    .contact-info {
        background-color: #f0f0f0;
        padding: 10px 20px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .contact-info li {
        margin-bottom: 5px;
        color: #333;
    }

    .contact-info strong {
        color: #007BFF;
    }

    /* Estilo para enlaces */
    a {
        color: #007BFF;
        text-decoration: none;
        transition: color 0.3s, text-decoration 0.3s;
    }

    a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Estilos adicionales para resaltar detalles */
    .highlight {
        background-color: #f8f8f8;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    td.header {
        background-color: #004170;
        /* Cambia el color de fondo a un color sólido */
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    h2 {
        font-size: 24px;
        /* Cambia el tamaño de la etiqueta h2 según tus preferencias */
        margin: 0;
        color: #fff;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    .logo {
        background-color: #fff;
    }
    </style>
</head>

<body>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">

        <tr>
            <td class="header">
                <img src="https://www.doblamos.com/wp-content/uploads/2019/10/simbolo.png" alt="Logo de Doblamos"
                    width="100" height="100">
                <h2 style="font-family: Arial, sans-serif; font-size: 28px;">Notificación Solicitud de Crédito</h2>
            </td>

        </tr>
        <tr>
            <td>
                <p style="font-size: 16px;">¡Te informamos que tu cliente:</p>
                </strong>


                <div class="highlight">

                    <ul>
                        <li><strong>Nombre de la Empresa o Persona : </strong> {{ $nombreSolicitante }}</li>
                        <li><strong>NIT:</strong> {{ $nit }}</li>
                        <p style="font-size: 16px;">¡Realizo una solicitud de credito con nosotros por un valor de:
                        </p>
                        <li><strong>Monto Solicitado:</strong> ${{ number_format($montoSolicitado, 2, ',', '.') }}
                        </li>

                        <li><strong>Plazo del Crédito (días):</strong> {{ $plazoCreditoMeses }}</li>
                    </ul>
                </div>
                <p>La solicitud se encuentra en revisión:</p>
                <div class="highlight">
                    <ul>
                        <li><strong>Número de Radicado:</strong> {{ $radicado }}</li>
                    </ul>
                </div>
                <p>
                    Mantendremos contacto contigo para informarte sobre el estado de la solicitud. Si tienes alguna
                    pregunta o necesitas asistencia adicional, no dudes en contactarnos.

                    Además, recuerda que puedes consultar el estado de tu solicitud en nuestro portal de clientes
                    utilizando el número de radicado y el NIT del cliente. Para acceder al portal, haz clic en el
                    siguiente enlace: <a href="https://www.portal.doblamos.com/">Portal de Clientes</a>.
                </p>


                <p class="signature">Cordialmente,</p>
                <p class="signature">Departamento de cartera</p>

            </td>
        </tr>
        <tr>
            <td class="footer">
                <p class="footer-text">&copy; {{ date('Y') }} Doblamos S.A. Todos los derechos reservados.</p>

            </td>
        </tr>


    </table>
</body>

</html>