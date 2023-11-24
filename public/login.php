<?php
  // Inicia la sesión
  session_start();

  // Incluye el archivo que contiene la conexión a la base de datos
  include "../src/php/conexion_bd.php";
  // Incluye el archivo que contiene el modelo de la base de datos
  include "../src/php/modelo_bd.php";
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="authors" content="Ricardo Isaza, Luis Espinosa y Jairo López" />
    <meta name="description" content="Página para el inicio de sesión" />
    <title>Inicio de sesión - Flavor Hunt</title>
    <link rel="stylesheet" href="../style/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">

    <link
      rel="shortcut icon"
      href="./assets/imgs/icon.png"
      type="image/x-icon"
    />

    <!-- Uso de SweetAlert2 para las alertas y link del css para las ediciones -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../style/alerta.css" />
  </head>

  <body>
    <?php
      // Llama a la función iniciarSesion()      
      iniciarSesion();
    ?>
    
    <!-- Contenedor del inicio de sesión -->
    <div id="login-container">
      
      <!-- Formulario de inicio de sesión -->
      <form id="login-form">
        <!-- Campos para iniciar seasión -->
        <fieldset>
          <legend><h1>¡Iniciar sesión!</h1></legend>

          <p>
            <label for="email">Correo electrónico</label>
            <input
              type="email"
              name="txtEmail"
              id="email"
              autocomplete="off"
              required
              autofocus
            />
          </p>

          <p>
            <label for="password">Contraseña</label>
            <input
              type="password"
              name="txtPassword"
              id="password"
              autocomplete="off"
              required
            />
          </p>
        </fieldset>

        <p><a href="./forgot_password.php">¿Olvidó su contraseña?</a></p>

        <div id="boton-login">
          <button onclick="window.location.href = 'signup.php';">
            CREAR CUENTA
          </button>
          
          <button name="btnToAccess" formaction="login.php" formmethod="post">
            ACCEDER
          </button>
        </div>

      </form>

    </div>

  </body>
</html>
