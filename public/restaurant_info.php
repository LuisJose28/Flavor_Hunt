<?php
  // Inicia la sesión
  session_start();

  // Incluye el archivo que contiene la conexión a la base de datos
  include "../src/php/conexion_bd.php";
  // Incluye el archivo que contiene el modelo de la base de datos
  include "../src/php/modelo_bd.php";

  function obtenerFechaMinima() {
    // Crea un objeto DateTimeZone para la zona horaria de América/Panamá
    $zonaHorariaPanama = new DateTimeZone('America/Panama');
    // Crea un objeto DateTime con la fecha y hora actuales en la zona horaria de América/Panamá
    $fechaMinima = new DateTime('now', $zonaHorariaPanama);

    // Devuelve la fecha formateada como 'Y-m-d'
    return $fechaMinima->format('Y-m-d');
  }

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
    <meta name="description" content="Página para consultar la información de un restaurante" />
    <title>Información del restaurante - Flavor Hunt</title>
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
      <?php
        // Llama a la función crearReserva()
        crearReserva();
      ?> 
      <!-- Titulo de la página -->
      <div class="titulo-página-restaurant-info">
        <h2>
          <?php
            // Llama a la función consultarNombreRestaurante()
            consultarNombreRestaurante();
          ?>
        </h2>
      </div>

      <section id="restaurant-info">
        <article class="slider-restaurant-info">
          <!-- Seccion para slider de la pagina -->

          <!-- Slider de imagenes del restaurante -->
          <div id="slider">
            <ul>
              <?php
                // Llama a la función consultarFotosRestaurante()
                consultarFotosRestaurante();
              ?>
            </ul>
          </div>
        </article>

        <article class="tabs-restaurant-info">
          <!-- Menú de navegación con tabs que contiene la información del restaurante -->

          <div id="restaurant-tabs">
            <ul class="label-menu">
              <li>
                <a href=".tab1"><span>Descripción</span></a>
              </li>
              <li>
                <a href=".tab2"><span>Menú</span></a>
              </li>
              <?php
                // Verifica si se ha enviado una solicitud GET
                if($_GET){
                  // Verifica si el valor de 'tipo_restaurante' no es igual a "Fonda"
                  if($_GET['tipo_restaurante']!=="Fonda"){
              ?>
                <!-- Si la condición es verdadera, muestra el siguiente fragmento HTML -->
                <li>
                  <a href=".tab3"><span>Reservar</span></a>
                </li>
              <?php
                  }
                }
              ?>
            </ul>

            <div class="content">
              <article class="tab1">
                <?php 
                  // Llama a la función consultarInfoRestaurante()
                  consultarInfoRestaurante();
                ?>
              </article>

              <article class="tab2">
                <div class="row-restaurant-menu">
                  <?php
                    // Llama a la función consultarPlatosRestaurante()
                    consultarPlatosRestaurante();
                  ?>
                </div>

                <p id="boton-descargar-menu">
                  <a href="../assets/pdfs/menu.pdf" download
                    ><i
                      class="fontawesome-restaurant-info fa-solid fa-download"
                    ></i>
                    Descargar Menú</a
                  >
                </p>
              </article>

              <?php
                // Verifica si se ha enviado una solicitud GET
                if($_GET){
                  // Verifica si el valor de 'tipo_restaurante' no es igual a "Fonda"
                  if($_GET['tipo_restaurante']!=="Fonda"){
              ?>
                <!-- Si la condición es verdadera, muestra el siguiente fragmento HTML -->
                <article class="tab3">
                  <div id="reservar-container">
                    <!-- Formulario reservar restaurante -->
                    <form
                      action=<?php
                          // Llama a la función imprimirUrlInfoRestaurante()
                          imprimirUrlInfoRestaurante();
                        ?>
                      method="post"
                      id="reservar-form"
                    >
                      <p>
                        <label for="reservation-date">Fecha deseada:</label>
                        <input
                          type="date"
                          name="txtReservationDate"
                          id="reservation-date"
                          min="<?php
                            // Llama e imprime el resultado de la función obtenerFechaMinima()
                            echo obtenerFechaMinima(); 
                          ?>"
                          autofocus
                          required
                        />
                      </p>

                      <p>
                        <label for="reservation-hour">Hora deseada:</label>
                        <input
                          type="time"
                          name="txtReservationHour"
                          id="reservation-hour"
                          step="900"
                          <?php
                            // Llama a la función restringirHorasReserva()
                            restringirHorasReserva();
                          ?>
                          required
                        />
                      </p>

                      <p>
                        <label for="reservation-peoples"
                          >Número de personas:</label
                        >
                        <input
                          type="number"
                          name="txtReservationPeoples"
                          id="reservation-peoples"
                          min="1"
                          max="10"
                          required
                        />
                      </p>

                      <?php
                        // Llama a la función validarMenuNinnios()
                        validarMenuNinnios();
                      ?>

                      <p class="block-grid">
                        <label for="comment">Comentario adicional:</label>
                        <br />
                        <textarea
                          name="txtReservationComment"
                          id="comment"
                          cols="35"
                          rows="4"
                          required
                        ></textarea>
                      </p>

                      <p class="block-grid">
                        <button>Reservar</button>
                      </p>
                    </form>
                  </div>
                </article>
              <?php
                  }
                }
              ?>
            </div>
          </div>
        </article>
      </section>
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
