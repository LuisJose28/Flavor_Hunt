<?php
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
    <meta name="description" content="Página para reestablecer la contraseña" />
    <title>Reestablecer contraseña - Flavor Hunt</title>
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
      // Llama a la función cambiarContrasennia()
      cambiarContrasennia();
    ?>
    <!-- Contenedor del reestablecimiento de contraseña -->
    <div id="forgot-password-container">
      <!-- Formulario de reestablecimiento de contraseña  -->
      <form id="forgot-password-form" action="./forgot_password.php" method="post">
        <!-- Campos para reestablecer la contraseña -->
        <fieldset>
          <legend><h1>¿Olvidó su contraseña?</h1></legend>

          <p>
            <label for="email">Correo electrónico:</label>
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
            <label for="new-password">Nueva contraseña:</label>
            <input
              type="password"
              name="txtNewPassword"
              id="new-password"
              autocomplete="off"
              required
            />
          </p>

          <p>
            <label for="confirm-new-password">Confirmar nueva contraseña:</label>
            <input
              type="password"
              name="txtConfirmNewPassword"
              id="confirm-new-password"
              autocomplete="off"
              required
            />
          </p>
        </fieldset>

        

        <div id="boton-forgot-password">
          <button>
            CAMBIAR CONTRASEÑA
          </button>
        </div>

      </form>

    </div>

  </body>
</html>
