


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
        font-family: 'Arial', sans-serif;
            background-image: url('{{asset('images/Fondo.jpg')}}');
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-size: cover;
            background-repeat: no-repeat;
    }

    .error-container {
      position: relative;
      text-align: center;
    }

    .error-alert {
      background-color:  #95E962;
      color: #fff;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      opacity: 0;
      transform: translateY(-20px);
      animation: showAnimation 0.5s ease-out forwards;
    }

    @keyframes showAnimation {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .error-icon {
      position: absolute;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 24px;
    }
  </style>
</head>
<body>
  <div class="error-container">
    <div class="error-alert">
      <span class="error-icon">⚠️</span>
      <h2>Solicitud de crédito rechazada con éxito</h2>
   
    </div>
  </div>
</body>
</html>




