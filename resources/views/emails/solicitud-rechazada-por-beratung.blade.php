<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Crédito Aprobada</title>

    <style>
    body {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .highlight {
        background-color: #f8f8f8;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 10px;
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
        background-color: #004170;
        color: #fff;
        text-align: center;
        padding: 20px 0;


    }


    h1 {
        font-size: 36px;
        margin: 0;
        color: #fff;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        /* Fuente de respaldo */
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
        /* Estilo de firma aumentado */
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

    /* Estilo para enlaces */
    a {
        color: #007BFF;
        text-decoration: none;
        transition: color 0.3s, text-decoration 0.3s;
    }

    a:hover {
        background-color: #004170;
        text-decoration: underline;
    }

    /* Estilo para el icono de aprobación */
    .approval-icon {
        font-size: 24px;
        color: #4CAF50;
        /* Color verde para el icono de aprobación */
    }

    .header {
        background-color: #004170;
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    h1 {
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

    .h2 {
        color: #fff;
    }
    </style>


</head>

<body>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0">
        <!-- Agregar un ícono de rechazo -->
        <tr>
            <td class="header"
                style="background: linear-gradient(to right, #004170, ); color: #fff; text-align: center; padding: 20px 0;">
                <img src="https://www.doblamos.com/wp-content/uploads/2019/10/simbolo.png" alt="Logo de Doblamos"
                    width="100" height="100">
                <h2 style="font-family: Arial, sans-serif; font-size: 28px;">Solicitud de Crédito Rechazada</h2>
                <!-- Icono de rechazo -->
            </td>
        </tr>


        <tr>
            <td>
                <p>Señores,</p>

                <p>Cartera Doblamos</p>

                <p>Le informamos que después de hacer el análisis y estudio de los documentos solicitados, estos no
                    cumplen con las políticas y parámetros de la Empresa, por consiguiente, no ha sido aprobado el cupo
                    de crédito.</p>
                <p><strong>{{ $nombreSolicitante }}</strong></p>
                <!-- No necesitas la variable $solicitud->Nit aquí -->
                <p>Asunto: Aprobación de Crédito</p>
                <div class="highlight">
                    <ul>
                        <li><strong>Número de Radicado:</strong> {{ $radicado }}</li>
                    </ul>
                </div>

               
                
                <p>Cordialmente,</p>
                <p class="signature">Beratung</p>
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