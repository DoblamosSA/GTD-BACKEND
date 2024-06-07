<!-- resources/views/notificacion_aprobacion.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Aprobación</title>
  
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11">
    <style>
        .swal2-popup {
            background-color: white; 
        }
    </style>
</head>
<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(isset($error_message))
            // Error desde el controlador
            Swal.fire({
                icon: 'error',
                title: 'Error al procesar la solicitud',
                text: '{{ $error_message }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Haz algo en caso de error si es necesario
                }
            });
        @else
            // En caso de éxito
            Swal.fire({
                icon: 'success',
                title: 'Gracias por tu afirmación',
                showConfirmButton: true,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'http://gestioncalidad.test/';
                }
            });
        @endif
    </script>
</body>
</html>
