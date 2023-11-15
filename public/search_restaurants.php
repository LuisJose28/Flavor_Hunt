<?php
  // Inicia la sesión
  session_start();

  // Incluye el archivo que contiene la conexión a la base de datos
  include "../src/php/conexion_bd.php";
  // Incluye el archivo que contiene el modelo de la base de datos
  include "../src/php/modelo_bd.php";

  // Captura los valores del formulario de filtros
  $txt_tipoComida=(isset($_POST["txtFoodType"]))?$_POST["txtFoodType"]:"";
  $txt_provincia=(isset($_POST["txtProvince"]))?$_POST["txtProvince"]:"";
  $txt_costo=(isset($_POST["txtCost"]))?$_POST["txtCost"]:"";
  $txt_facilidades=(isset($_POST["txtFacilities"]))?$_POST["txtFacilities"]:"";

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
    <meta name="description" content="Página para buscar restaurantes" />
    <title>Buscar restaurantes - Flavor Hunt</title>
    <link rel="stylesheet" href="../style/main.css" />

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
  </head>
  <body>
    <!-- El sub-header es un header distinto para todas las paginas diferentes al home -->
    <header class="sub-header">
      <nav>
        <a href="home.php"><img src="../assets/imgs/logo-flavorhunt.webp" alt="Logo de Flavor Hunt" loading="lazy"></a>  

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

    <main>
      <!-- Contenido principal -->

      <!-- Titulo de la página -->
      <div class="titulo-página-search">
        <h2>Buscar <?php if($_GET){ echo $_GET['tipo_restaurante'];}?></h2>
      </div>

      <section id="search-restaurants">
        
        <article class="filtro-buscador">
          
          <!-- Seccion para filtrar las cafeterías -->
          <form
            action="search_restaurants.php?tipo_restaurante=<?php if($_GET){ echo $_GET['tipo_restaurante'];}?>" method="post"
            id="restaurants-filters">

            <!-- Filtro de tipo de comida -->
            <details id="food-type-filter">
              <summary>TIPO DE COMIDA</summary>
              <div class="seccion-acordeon">
                <div>
                  <input
                    type="radio"
                    name="txtFoodType"
                    id="italian"
                    value="Italiana"
                    <?php if($_POST){if($txt_tipoComida==="Italiana"){ ?> checked <?php }} ?>
                  />
                  <label for="italian">Italiana</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtFoodType"
                    id="mexican"
                    value="Mexicana"
                    <?php if($_POST){if($txt_tipoComida==="Mexicana"){ ?> checked <?php }} ?>
                  />
                  <label for="mexican">Mexicana</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtFoodType"
                    id="american"
                    value="Americana"
                    <?php if($_POST){if($txt_tipoComida==="Americana"){ ?> checked <?php }} ?>
                  />
                  <label for="american">Americana</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtFoodType"
                    id="panamenian"
                    value="Panameña"
                    <?php if($_POST){if($txt_tipoComida==="Panameña"){ ?> checked <?php }} ?>
                  />
                  <label for="panamenian">Panameña</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtFoodType"
                    id="chinese"
                    value="China"
                    <?php if($_POST){if($txt_tipoComida==="China"){ ?> checked <?php }} ?>
                  />
                  <label for="chinese">China</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtFoodType"
                    id="japanese"
                    value="Japonesa"
                    <?php if($_POST){if($txt_tipoComida==="Japonesa"){ ?> checked <?php }} ?>
                  />
                  <label for="japanese">Japonesa</label>
                </div>
              </div>
            </details>

            <!-- Filtro de provincia -->
            <details id="province-filter">
              <summary>PROVINCIA</summary>
              <div class="seccion-acordeon">
                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province1"
                    value="Panamá"
                    <?php if($_POST){if($txt_provincia==="Panamá"){ ?> checked <?php }} ?>
                  />
                  <label for="province1">Panamá</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province2"
                    value="Panamá Oeste"
                    <?php if($_POST){if($txt_provincia==="Panamá Oeste"){ ?> checked <?php }} ?>
                  />
                  <label for="province2">Panamá Oeste</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province3"
                    value="Colón"
                    <?php if($_POST){if($txt_provincia==="Colón"){ ?> checked <?php }} ?>
                  />
                  <label for="province3">Colón</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province4"
                    value="Los Santos"
                    <?php if($_POST){if($txt_provincia==="Los Santos"){ ?> checked <?php }} ?>
                  />
                  <label for="province4">Los Santos</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province5"
                    value="Herrera"
                    <?php if($_POST){if($txt_provincia==="Herrera"){ ?> checked <?php }} ?>
                  />
                  <label for="province5">Herrera</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province6"
                    value="Veraguas"
                    <?php if($_POST){if($txt_provincia==="Veraguas"){ ?> checked <?php }} ?>
                  />
                  <label for="province6">Veraguas</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province7"
                    value="Chiriquí"
                    <?php if($_POST){if($txt_provincia==="Chiriquí"){ ?> checked <?php }} ?>
                  />
                  <label for="province7">Chiriquí</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province8"
                    value="Bocas del Toro"
                    <?php if($_POST){if($txt_provincia==="Bocas del Toro"){ ?> checked <?php }} ?>
                  />
                  <label for="province8">Bocas del Toro</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province9"
                    value="Coclé"
                    <?php if($_POST){if($txt_provincia==="Coclé"){ ?> checked <?php }} ?>
                  />
                  <label for="province9">Coclé</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtProvince"
                    id="province10"
                    value="Darién"
                    <?php if($_POST){if($txt_provincia==="Darién"){ ?> checked <?php }} ?>
                  />
                  <label for="province10">Darién</label>
                </div>
              </div>
            </details>

            <!-- Filtro de costo -->
            <details id="cost-filter">
              <summary>COSTO</summary>
              <div class="seccion-acordeon">
                <div>
                  <input
                    type="radio"
                    name="txtCost"
                    id="cheap"
                    value="Barato"
                    <?php if($_POST){if($txt_costo==="Barato"){ ?> checked <?php }} ?>
                  />
                  <label for="cheap">Barato</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtCost"
                    id="regular"
                    value="Regular"
                    <?php if($_POST){if($txt_costo==="Regular"){ ?> checked <?php }} ?>
                  />
                  <label for="regular">Regular</label>
                </div>

                <div>
                  <input
                    type="radio"
                    name="txtCost"
                    id="expensive"
                    value="Caro"
                    <?php if($_POST){if($txt_costo==="Caro"){ ?> checked <?php }} ?>
                  />
                  <label for="expensive">Caro</label>
                </div>
              </div>
            </details>

            <!-- Filtro de facilidades -->
            <details id="facilities-filter">
              <summary>FACILIDADES</summary>
              <div class="seccion-acordeon">
                <div>
                  <input
                    type="checkbox"
                    name="txtFacilities[]"
                    id="baby-chair"
                    value="Silla de bebé"
                    <?php if($_POST){if(is_array($txt_facilidades)){foreach($txt_facilidades as $facilidad){if($facilidad==="Silla de bebé"){echo "checked";}}}} ?>
                  />
                  <label for="baby-chair">Silla de bebé</label>
                </div>

                <div>
                  <input
                    type="checkbox"
                    name="txtFacilities[]"
                    id="children-menu"
                    value="Menú de niños"
                    <?php if($_POST){if(is_array($txt_facilidades)){foreach($txt_facilidades as $facilidad){if($facilidad==="Menú de niños"){echo "checked";}}}} ?>
                  />
                  <label for="children-menu">Menú de niños</label>
                </div>

                <div>
                  <input
                    type="checkbox"
                    name="txtFacilities[]"
                    id="baby-changer"
                    value="Cambiador"
                    <?php if($_POST){if(is_array($txt_facilidades)){foreach($txt_facilidades as $facilidad){if($facilidad==="Cambiador"){echo "checked";}}}} ?>
                  />
                  <label for="baby-changer">Cambiador</label>
                </div>

                <div>
                  <input
                    type="checkbox"
                    name="txtFacilities[]"
                    id="disabled-accessibility"
                    value="Accesibilidad para discapacitados"
                    <?php if($_POST){if(is_array($txt_facilidades)){foreach($txt_facilidades as $facilidad){if($facilidad==="Accesibilidad para discapacitados"){echo "checked";}}}} ?>
                  />
                  <label for="disabled-accessibility"
                    >Accesibilidad para discapacitados</label
                  >
                </div>

                <div>
                  <input
                    type="checkbox"
                    name="txtFacilities[]"
                    id="parking"
                    value="Parking"
                    <?php if($_POST){if(is_array($txt_facilidades)){foreach($txt_facilidades as $facilidad){if($facilidad==="Parking"){echo "checked";}}}} ?>
                  />
                  <label for="parking">Parking</label>
                </div>
              </div>
            </details>

            <button href>FILTRAR</button>
          </form>
        </article>

        
        <article class="restaurantes-buscados">
          <!-- Filtros seleccionados por el usuario -->
          <ul id="selected-restaurants-filters">
            <?php
              // Llama a la función imprimirFiltros()
              imprimirFiltros(); 
            ?>
          </ul>
          
          <!-- Restaurantes buscados -->
          <div class="row-search">
            <?php
              // Llama a la función buscarRestaurantes()
              buscarRestaurantes();
            ?>
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
