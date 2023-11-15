<?php
  // Inicia la sesión
  session_start();

  // Incluye el archivo que contiene la conexión a la base de datos
  include "../src/php/conexion_bd.php";
  // Incluye el archivo que contiene el modelo de la base de datos
  include "../src/php/modelo_bd.php";

  // Verifica si no hay un usuario autenticado
  if(empty($_SESSION["id_usuario"])){
    // Redirige a la página de inicio de sesión si no hay un usuario autenticado
    header("Location: login.php");
    // Detiene la ejecución del script después de la redirección
    exit();
  }
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="authors" content="Ricardo Isaza, Luis Espinosa y Jairo López" />
    <meta name="description" content="Página para buscar cafeterías" />
    <title>Información de las reservas - Flavor Hunt</title>
    <link rel="stylesheet" href="../style/main.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../src/js/tabs.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap"
      rel="stylesheet"
    />

    <script
      src="https://kit.fontawesome.com/ff747d13fc.js"
      crossorigin="anonymous"
    ></script>

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
    <!-- El sub-header es un header distinto para todas las paginas diferentes al home -->
    <header class="sub-header">
      <nav>
        <a href="home.php"
          ><img
            src="../assets/imgs/logo-flavorhunt.webp"
            alt="Logo de Flavor Hunt"
            loading="lazy"
        /></a>

        <div class="nav-links" id="navLinks">
          <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>

          <ul>
            <li><a href="home.php">HOME</a></li>
            <li><a href="search_restaurants.php?tipo_restaurante=Cafetería">CAFETERÍAS</a></li>
            <li><a href="search_restaurants.php?tipo_restaurante=Fonda">FONDAS</a></li>
            <li><a href="search_restaurants.php?tipo_restaurante=Restaurante">RESTAURANTES</a></li>
            <li><a href="search_restaurants.php?tipo_restaurante=Bar">BARES</a></li>
            <li><a href="search_restaurants.php?tipo_restaurante=Buffet">BUFFETS</a></li>
            <li><a href="reservation_info.php">CONSULTAR RESERVAS</a></li>
          </ul>
        </div>
        <i class="fa-solid fa-bars" onclick="showMenu()"></i>
      </nav>

      <!-- JAVASCRIPT -->
      <script>
        var navLinks = document.getElementById("navLinks");

        function showMenu() {
          navLinks.style.right = "0";
        }

        function hideMenu() {
          navLinks.style.right = "-200px";
        }
      </script>
    </header>

    <!-- Contenido principal -->
    <main>
      <!-- Seccion reservation_info -->
      <section id="reservation-info">
        <h2>Reservas registradas</h2>

        <!-- Menú de navegación con tabs -->
        <div id="reservation-tabs">
          <ul class="label-menu-reservation">
            <li>
              <a href=".tab1-reservation-info"><span>Próximamente</span></a>
            </li>
            <li>
              <a href=".tab2-reservation-info"><span>Completado</span></a>
            </li>
          </ul>

          <div class="content-reservation">
            <article class="tab1-reservation-info">
              <!-- Formulario reservar restaurante -->
              <?php
                // Llama a la función consultarReservasProximas()
                consultarReservasProximas();
              ?>
            </article>

            <article class="tab2-reservation-info">
              <!-- Formulario reservar restaurante -->
              <?php
                // Llama a la función consultarReservasCompletadas()
                consultarReservasCompletadas();
              ?>
            </article>
          </div>
        </div>
      </section>

      <?php
        // Llama a la función eliminarReserva()
        eliminarReserva();
      ?>
    </main>

    <!-- Pie de la página -->
    <footer>
      <!-- Menu secundario -->
      <div class="menu-secundario">
        <h3>Páginas web de Flavor Hunt</h3>
        <hr />

        <nav aria-label="secondary-nav" class="nav-secundario">
          <ul>
            <li><a href="home.php">Home</a></li>

            <li>
              Tipos de Restaurantes:
              <ul class="menu-secundario-vertical">
                <li><a href="search_restaurants.php?tipo_restaurante=Cafetería">Cafeterías</a></li>
                <li><a href="search_restaurants.php?tipo_restaurante=Fonda">Fondas</a></li>
                <li><a href="search_restaurants.php?tipo_restaurante=Restaurante">Restaurantes</a></li>
                <li><a href="search_restaurants.php?tipo_restaurante=Bar">Bares</a></li>
                <li><a href="search_restaurants.php?tipo_restaurante=Buffet">Buffets</a></li>
              </ul>
            </li>

            <li><a href="reservation_info.php">Consultar reservas</a></li>
          </ul>
        </nav>

        <!-- Mensaje de copy right  -->
        <h4>Flavor Hunt &COPY; 2023 | Privacy policy</h4>

        <!-- Enlace para cerrar sesión -->
        <p id="boton-cerrarsesicon"><a href="./destroy_session.php">Cerrar sesión</a></p>
      </div>
    </footer>
  </body>
</html>
