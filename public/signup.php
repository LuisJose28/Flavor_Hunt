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
    <meta name="description" content="Página para el registro de usuario" />
    <title>Crear una cuenta - Flavor Hunt</title>
    <link rel="stylesheet" href="../style/main.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap"
      rel="stylesheet"
    />

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
      // Llama a la función crearUsuario()
      crearUsuario();
    ?>
    
    <!-- Contenedor del registro de usuario -->
    <div id="signup-container">
      <h1>¡Crea tu cuenta!</h1>

      <!-- Formulario de registro -->
      <form action="./signup.php" method="post" id="signup-form">
        <!-- Campos para registrar los detalles de la cuenta -->
        <fieldset id="account-details">
          <legend><h2>Detalles de la cuenta</h2></legend>

          <p>
            <label for="name">Nombre</label>
            <input
              type="text"
              name="txtName"
              id="name"
              autocomplete="off"
              required
              autofocus
            />
          </p>

          <p>
            <label for="last-name">Apellido</label>
            <input
              type="text"
              name="txtLastName"
              id="last-name"
              autocomplete="off"
              required
            />
          </p>

          <p>
            <label for="birth-date">Fecha de nacimiento</label>
            <input type="date" name="txtBirthDate" id="birth-date" required />
          </p>

          <p>
            <label for="gender">Género</label>
            <select name="txtGender" id="gender" required>
              <option value="" disabled selected>Elige una opción</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
            </select>
          </p>
        </fieldset>

        <!-- Campos para registrar las credenciales de la cuenta -->
        <fieldset id="account-credentials">
          <legend><h2>Credenciales de la cuenta</h2></legend>

          <p>
            <label for="email">Correo electrónico</label>
            <input
              type="email"
              name="txtEmail"
              id="email"
              autocomplete="off"
              required
            />
          </p>

          <p>
            <label for="phone">Teléfono</label>
            <input
              type="tel"
              name="txtPhone"
              id="phone"
              placeholder="5555-5555"
              pattern="[0-9]{4}-[0-9]{4}"
              required
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

          <p>
            <label for="confirm-password">Confirmar contraseña</label>
            <input
              type="password"
              name="txtConfirmPassword"
              id="confirm-password"
              autocomplete="off"
              required
            />
          </p>
        </fieldset>

        <p id="boton-signup">
          <button>CREAR CUENTA</button>
        </p>
      </form>
    </div>
  </body>
</html>
