<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

    <style>
        .swal2-text {
            color: #333; 
        }
    </style>
</head>
<body>
    <h1>Solicitud de Compra {{ $estado }}</h1>
    <p>La solicitud de compra con el ID <b>{{ $solicitud->id }}</b> ha sido {{ $estado === 'Aprobada' ? 'aprobada' : 'rechazada' }}</p>

    

</body>
</html>