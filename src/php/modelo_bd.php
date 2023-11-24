<?php
    include "conexion_bd.php";

    function crearUsuario(){
        if($_POST){
            // Establecer la conexión a la base de datos
            global $conexion;

            // Obtener y escapar los valores del formulario
            $nombre=trim(mysqli_real_escape_string($conexion,$_POST["txtName"]));
            $apellido=trim(mysqli_real_escape_string($conexion,$_POST["txtLastName"]));
            $fechaNac=mysqli_real_escape_string($conexion,$_POST["txtBirthDate"]);
            $genero=mysqli_real_escape_string($conexion,$_POST["txtGender"]);
            $correo=mysqli_real_escape_string($conexion,$_POST["txtEmail"]);
            $telefono=mysqli_real_escape_string($conexion,$_POST["txtPhone"]);
            $contra=trim(mysqli_real_escape_string($conexion,$_POST["txtPassword"]));
            $confirmarContra=trim(mysqli_real_escape_string($conexion,$_POST["txtConfirmPassword"]));

            // Validar campos obligatorios
            if($nombre==="" || $apellido==="" || $contra==="" || $confirmarContra===""){
                echo "<script>
                    // Mostrar alerta de error
                    Swal.fire({
                        title: 'Oops...',
                        text: '¡No se admiten campos vacíos!',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'custom-swal-button'
                        }
                    });
                </script>";
            }else{
                // Validar si las contraseñas coinciden
                if($contra===$confirmarContra){
                    // Verificar si el correo ya existe en la base de datos
                    $query="SELECT * FROM `usuarios` WHERE `correo`='$correo'";
                    $result=mysqli_query($conexion,$query);

                    if (!$result) {
                        die("Error en la consulta: " . mysqli_error($conexion));
                    }else if(mysqli_num_rows($result) > 0){
                        // Mostrar alerta de error si el correo ya existe
                        echo "<script>
                            Swal.fire({
                                title: 'Oops...',
                                text: '¡El correo ya existe en la base de datos!',
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    confirmButton: 'custom-swal-button'
                                }
                            });
                        </script>";
                    }else{
                        // Insertar nuevo usuario en la base de datos
                        $query="INSERT INTO `usuarios` (`nombre`,`apellido`,`fecha_nac`,`genero`,`correo`,`contrasennia`,`telefono`) VALUES ('$nombre','$apellido','$fechaNac','$genero','$correo','$contra','$telefono')";
                        $result=mysqli_query($conexion,$query);
    
                        if ($result) {
                            // Mostrar alerta de éxito y redirigir después de un tiempo
                            echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "¡Has sido registrado con éxito!",
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    window.location.href = "login.php";
                                });
                            </script>';
                        }else{
                            // Mostrar mensaje de error si la inserción falla
                            die('La inserción de los datos ha fallado!'. mysqli_error($conexion));
                        }
                    }
                }else{
                    // Mostrar alerta de error si las contraseñas no coinciden
                    echo "<script>
                        Swal.fire({
                            title: 'Oops...',
                            text: '¡Las contraseñas no coinciden!',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                confirmButton: 'custom-swal-button'
                            }
                        });
                    </script>";
                }
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
        }
    }

    function cambiarContrasennia(){
        if($_POST){
            // Establecer la conexión a la base de datos
            global $conexion;

            // Obtener y escapar los valores del formulario
            $correo=mysqli_real_escape_string($conexion,$_POST["txtEmail"]);
            $contra=trim(mysqli_real_escape_string($conexion,$_POST["txtNewPassword"]));
            $confirmarContra=trim(mysqli_real_escape_string($conexion,$_POST["txtConfirmNewPassword"]));

            // Verificar si el usuario está registrado
            $query="SELECT * FROM `usuarios` WHERE `correo`='$correo'";
            $result=mysqli_query($conexion,$query);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            }else if(mysqli_num_rows($result) > 0){
                // Validar campos obligatorios
                if($contra==="" || $confirmarContra===""){
                    echo "<script>
                        // Mostrar alerta de error
                        Swal.fire({
                            title: 'Oops...',
                            text: '¡No se admiten campos vacíos!',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                confirmButton: 'custom-swal-button'
                            }
                        });
                    </script>";
                }else{
                    // Validar si las contraseñas coinciden
                    if($contra===$confirmarContra){
                        // Actualizar la contraseña en la base de datos
                        $query="UPDATE `usuarios` SET `contrasennia`='$contra' WHERE `correo`='$correo'";
                        $result=mysqli_query($conexion,$query);
    
                        if ($result) {
                            // Mostrar alerta de éxito y redirigir después de un tiempo
                            echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "¡La contraseña se cambió exitosamente!",
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    window.location.href = "login.php";
                                });
                            </script>';
                        }else{
                            // Mostrar mensaje de error si la actualización falla
                            die('La inserción de los datos ha fallado!'. mysqli_error($conexion));
                        }
                    }else{
                        // Mostrar alerta de error si las contraseñas no coinciden
                        echo "<script>
                            Swal.fire({
                                title: 'Oops...',
                                text: '¡Las contraseñas no coinciden!',
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    confirmButton: 'custom-swal-button'
                                }
                            });
                        </script>";
                    }
                }
            }else{
                // Mostrar mensaje si el usuario no está registrado
                echo "<script>
                    Swal.fire({
                        title: 'Oops...',
                        text: '¡Usted no está debidamente registrado!',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'custom-swal-button'
                        }
                    });
                </script>";
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
        }
    }

    function iniciarSesion(){
        if($_POST){
            // Establecer la conexión a la base de datos
            global $conexion;

            // Obtener y escapar el correo y la contraseña del formulario
            $correo=mysqli_real_escape_string($conexion,$_POST["txtEmail"]);
            $contra=trim(mysqli_real_escape_string($conexion,$_POST["txtPassword"]));

            // Validar campos obligatorios
            if($contra===""){
                echo "<script>
                    // Mostrar alerta de error
                    Swal.fire({
                        title: 'Oops...',
                        text: '¡No se admiten campos vacíos!',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'custom-swal-button'
                        }
                    });
                </script>";
            }else{
                // Verificar las credenciales del usuario
                $query="SELECT * FROM `usuarios` WHERE `correo`='$correo' AND `contrasennia`='$contra'";
                $result=mysqli_query($conexion,$query);

                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                }else if(mysqli_num_rows($result) > 0){
                    // Las credenciales son correctas, se ha iniciado sesión
                    $row = mysqli_fetch_assoc($result);

                    // Almacenar el ID del usuario en la variable de sesión
                    $_SESSION["id_usuario"]=$row['id'];

                    // Mostrar alerta de éxito y redirigir después de un tiempo
                    echo '<script>
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Se ha iniciado sesión correctamente",
                            text: "¡Bienvenid@ ' . $row['nombre'] .' '. $row['apellido'] . '!",
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            window.location.href = "home.php";
                        });
                    </script>';
                }else{
                    // Mostrar mensaje de error si las credenciales son incorrectas
                    echo "<script>
                        Swal.fire({
                            title: 'Oops...',
                            text: '¡Usted no está debidamente registrado o los datos no coinciden!',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                confirmButton: 'custom-swal-button'
                            }
                        });
                    </script>";
                }
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
        }
    }

    function buscarRestaurantesCiudadPanama(){
        // Establecer la conexión a la base de datos
        global $conexion;

        // Consulta SQL para obtener información de restaurantes en la ciudad de Panamá
        $query = "SELECT restaurantes.id AS restaurante_id, restaurantes.nombre AS nombre, restaurantes.tipo_restaurante AS tipo_restaurante, sucursales.id AS id_sucursal, sucursales.provincia AS provincia, sucursales.direccion AS direccion, fotos_restaurantes.nombre AS nombre_foto FROM restaurantes JOIN sucursales ON restaurantes.id = sucursales.id_restaurante JOIN fotos_restaurantes ON restaurantes.id = fotos_restaurantes.id_restaurante WHERE sucursales.provincia = 'Panamá' AND fotos_restaurantes.nombre LIKE '%home' LIMIT 3";
        // Ejecutar la consulta
        $result=mysqli_query($conexion,$query);

        // Verificar si la consulta fue exitosa
        if (!$result) {
            die('La consulta a las tablas de restaurantes, sucursales y fotos de restaurantes ha fallado '. mysqli_error($conexion));
        }else{
            // Iterar sobre los resultados y mostrar la información de los restaurantes
            while ($row=mysqli_fetch_assoc($result)) {
                $restaurante_id = $row["restaurante_id"];
                $restaurante_nombre = $row["nombre"];
                $tipo_restaurante= $row["tipo_restaurante"];
                $sucursal_id = $row["id_sucursal"];
                $sucursal_provincia = $row["provincia"];
                $sucursal_direccion = $row["direccion"];
                $foto = $row["nombre_foto"];

                // Imprimir la información de cada restaurante
                echo "<a href='restaurant_info.php?restaurante_id=$restaurante_id&sucursal_id=$sucursal_id&tipo_restaurante=$tipo_restaurante' class='restaurantes-home-col'>
                <figure>
                  <img
                    src='../assets/imgs/restaurantes/$foto.webp'
                    alt='$restaurante_nombre'
                    loading='lazy'
                  />
                  <figcaption>$restaurante_nombre</figcaption>
                  <p><i class='fa-solid fa-location-dot'></i> $sucursal_direccion</p>
                </figure>
                </a>";
            }
        }
    }

    function buscarRestaurantesComidaLocal(){
        // Establecer la conexión a la base de datos
        global $conexion;

        // Consulta SQL para obtener información de restaurantes que ofrecen comida panameña
        $query = "SELECT restaurantes.id AS restaurante_id, restaurantes.nombre AS nombre, restaurantes.tipo_restaurante AS tipo_restaurante, sucursales.id AS id_sucursal, sucursales.provincia AS provincia, sucursales.direccion AS direccion, fotos_restaurantes.nombre AS nombre_foto FROM restaurantes JOIN sucursales ON restaurantes.id = sucursales.id_restaurante JOIN fotos_restaurantes ON restaurantes.id = fotos_restaurantes.id_restaurante WHERE restaurantes.tipo_comida = 'Panameña' AND fotos_restaurantes.nombre LIKE '%home' LIMIT 3";
        // Ejecutar la consulta
        $result=mysqli_query($conexion,$query);

        // Verificar si la consulta fue exitosa
        if (!$result) {
            die('La consulta a las tablas de restaurantes, sucursales y fotos de restaurantes ha fallado '. mysqli_error($conexion));
        }else{
            // Iterar sobre los resultados y mostrar la información de los restaurantes
            while ($row=mysqli_fetch_assoc($result)) {
                $restaurante_id = $row["restaurante_id"];
                $restaurante_nombre = $row["nombre"];
                $tipo_restaurante= $row["tipo_restaurante"];
                $sucursal_id = $row["id_sucursal"];
                $sucursal_provincia = $row["provincia"];
                $sucursal_direccion = $row["direccion"];
                $foto = $row["nombre_foto"];

                // Imprimir la información de cada restaurante
                echo "<a href='restaurant_info.php?restaurante_id=$restaurante_id&sucursal_id=$sucursal_id&tipo_restaurante=$tipo_restaurante' class='bares-home-col'>
                <figure>
                  <img src='../assets/imgs/restaurantes/$foto.webp' alt='$restaurante_nombre' loading='lazy' />
                </figure>
    
                <div class='layer'>
                  <h3>$restaurante_nombre<br>$sucursal_provincia - $sucursal_direccion</h3>
                </div>
                </a>";
            }
        }
    }

    function buscarRestaurantesElegantes(){
        global $conexion;
    
        $i = 0;
    
        // Consulta SQL para obtener información de restaurantes elegantes
        $query = "SELECT restaurantes.nombre AS nombre, sucursales.id AS id_sucursal, sucursales.provincia AS provincia, sucursales.direccion AS direccion, fotos_restaurantes.nombre AS nombre_foto FROM restaurantes JOIN sucursales ON restaurantes.id = sucursales.id_restaurante JOIN fotos_restaurantes ON restaurantes.id = fotos_restaurantes.id_restaurante WHERE restaurantes.costo = 'Caro' AND fotos_restaurantes.nombre LIKE '%home%' GROUP BY restaurantes.nombre LIMIT 3";
    
        // Ejecutar la consulta
        $result = mysqli_query($conexion, $query);
    
        // Verificar si la consulta fue exitosa
        if (!$result) {
            die('La consulta a las tablas de restaurantes, sucursales y fotos de restaurantes ha fallado '. mysqli_error($conexion));
        } else {
            // Iterar sobre los resultados y mostrar la información de los restaurantes
            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
    
                $restaurante_nombre = $row["nombre"];
                $sucursal_id = $row["id_sucursal"];
                $sucursal_provincia = $row["provincia"];
                $sucursal_direccion = $row["direccion"];
                $foto = $row["nombre_foto"];
    
                // Verificar el índice para mostrar un banner especial en la segunda iteración
                if ($i === 2) {
                    echo "<div class='imagenes-banner'>
                        <img
                          src='../assets/imgs/restaurantes/$foto.webp'
                          alt='$restaurante_nombre - $sucursal_direccion, $sucursal_provincia'
                          loading='lazy'
                        />
                        <div class='imagenes-banner-texto'>
                          <p>¡Los restaurantes más elegantes!</p>
                          <button onclick='window.location.href = `search_restaurants.php?tipo_restaurante=Restaurante`;'>
                            Ver todos<i class='chevron-banner fa-solid fa-chevron-right' ></i>
                          </button>
                        </div>
                        </div>";
                } else {
                    echo "<div class='imagenes-banner'>
                        <img
                          src='../assets/imgs/restaurantes/$foto.webp'
                          alt='$restaurante_nombre - $sucursal_direccion, $sucursal_provincia'
                          loading='lazy'
                        />
                        </div>";
                }
            }
        }
    }

    function buscarRestaurantesEconomicos(){
        global $conexion;
    
        // Consulta SQL para obtener información de restaurantes económicos
        $query = "SELECT restaurantes.id AS restaurante_id, restaurantes.nombre AS nombre, restaurantes.tipo_restaurante AS tipo_restaurante, sucursales.id AS id_sucursal, sucursales.provincia AS provincia, sucursales.direccion AS direccion, fotos_restaurantes.nombre AS nombre_foto FROM restaurantes JOIN sucursales ON restaurantes.id = sucursales.id_restaurante JOIN fotos_restaurantes ON restaurantes.id = fotos_restaurantes.id_restaurante WHERE restaurantes.costo = 'Barato' AND fotos_restaurantes.nombre LIKE '%home' LIMIT 4";
        
        // Ejecutar la consulta
        $result = mysqli_query($conexion, $query);
    
        // Verificar si la consulta fue exitosa
        if (!$result) {
            die('La consulta a las tablas de restaurantes, sucursales y fotos de restaurantes ha fallado '. mysqli_error($conexion));
        } else {
            // Iterar sobre los resultados y mostrar la información de los restaurantes
            while ($row = mysqli_fetch_assoc($result)) {
                $restaurante_id = $row["restaurante_id"];
                $restaurante_nombre = $row["nombre"];
                $tipo_restaurante= $row["tipo_restaurante"];
                $sucursal_id = $row["id_sucursal"];
                $sucursal_provincia = $row["provincia"];
                $sucursal_direccion = $row["direccion"];
                $foto = $row["nombre_foto"];
    
                // Imprimir la información de cada restaurante
                echo "<a href='restaurant_info.php?restaurante_id=$restaurante_id&sucursal_id=$sucursal_id&tipo_restaurante=$tipo_restaurante' class='cafeterias-home-col'>
                    <figure>
                      <img
                        src='../assets/imgs/restaurantes/$foto.webp'
                        alt='$restaurante_nombre'
                        loading='lazy'
                      />
                      <figcaption>$restaurante_nombre</figcaption>
                      <p><i class='fa-solid fa-location-dot'></i> $sucursal_provincia - $sucursal_direccion</p>
                    </figure>
                    </a>";
            }
        }
    
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    }

    function consultarFotosRestaurante(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;
    
            // Obtener el identificador del restaurante de la URL
            $restaurante_id = intval($_GET["restaurante_id"]);
    
            // Consulta SQL para obtener hasta 3 fotos del restaurante
            $query = "SELECT fotos_restaurantes.nombre FROM fotos_restaurantes JOIN restaurantes ON fotos_restaurantes.id_restaurante=restaurantes.id WHERE restaurantes.id=$restaurante_id LIMIT 3";
    
            // Ejecutar la consulta
            $result = mysqli_query($conexion, $query);
    
            // Verificar si la consulta fue exitosa
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            } else if(mysqli_num_rows($result) > 0){
                // Iterar sobre los resultados y mostrar las fotos del restaurante
                while ($row = mysqli_fetch_assoc($result)) {
                    $nombre_foto = $row['nombre'];
                    echo "<li>
                        <img
                        src='../assets/imgs/restaurantes/$nombre_foto.webp'
                        alt='$nombre_foto'
                        loading='lazy'/></li>";
                }
            }
        }
    }

    function consultarNombreRestaurante(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;
    
            // Obtener el identificador del restaurante de la URL
            $restaurante_id = intval($_GET["restaurante_id"]);
    
            // Consulta SQL para obtener el nombre del restaurante
            $query = "SELECT restaurantes.nombre FROM restaurantes WHERE restaurantes.id = $restaurante_id";
    
            // Ejecutar la consulta
            $result = mysqli_query($conexion, $query);
    
            // Verificar si la consulta fue exitosa
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            } else if(mysqli_num_rows($result) > 0){
                // Iterar sobre los resultados y mostrar el nombre del restaurante
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['nombre'];
                }
            } else {
                // Mostrar un mensaje predeterminado si no hay resultados
                echo "<h2>Nombre del restaurante</h2>";
            }
        }
    }

    function consultarInfoRestaurante(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;

            // Obtener los parámetros de la URL
            $restaurante_id=intval($_GET["restaurante_id"]);
            $sucursal_id=intval($_GET["sucursal_id"]);
            $tipo_restaurante=mysqli_real_escape_string($conexion,$_GET["tipo_restaurante"]);
    
            // Consulta SQL para obtener la información del restaurante y su sucursal
            $query = "SELECT restaurantes.tipo_comida, restaurantes.email, restaurantes.sitio_web, restaurantes.costo, sucursales.provincia, sucursales.direccion, sucursales.dia_apertura, sucursales.dia_cierre, sucursales.hora_apertura, sucursales.hora_cierre, sucursales.telefono FROM restaurantes JOIN sucursales ON restaurantes.id = sucursales.id_restaurante WHERE sucursales.id = $sucursal_id";
            // Ejecutar la consulta
            $result=mysqli_query($conexion,$query);

            // Verificar si la consulta fue exitosa y si hay resultados
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            }else if(mysqli_num_rows($result) > 0){
                // Iterar sobre los resultados y mostrar la información del restaurante y su sucursal
                while ($row=mysqli_fetch_assoc($result)) {
                    // Extraer los datos de la fila
                    $tipo_comida = $row["tipo_comida"];
                    $email = $row["email"];
                    $sitio_web = $row["sitio_web"];
                    $costo = $row["costo"];
                    $provincia = $row["provincia"];
                    $direccion = $row["direccion"];
                    $dia_apertura = $row["dia_apertura"];
                    $dia_cierre = $row["dia_cierre"];
                    $hora_apertura = $row["hora_apertura"];
                    $hora_cierre = $row["hora_cierre"];
                    $telefono = $row["telefono"];

                    // Mostrar la información dependiendo de la disponibilidad de email y sitio web
                    if(is_null($sitio_web) && !is_null($email)){
                        // ... (código para cuando falta el sitio web)
                        echo "<fieldset>
                        <legend><h3>Información local</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-map-location-dot'></i> Dirección</h4>
                        <p>$direccion</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-location-dot'></i> Provincia</h4>
                        <p>$provincia</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-clock'></i> Horario</h4>
                        <p>$dia_apertura a $dia_cierre desde las $hora_apertura hrs. hasta las $hora_cierre hrs.</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-phone'></i> Teléfono</h4>
                        <p><a href='tel:+507$telefono'>+507 $telefono</a></p>
                        </fieldset>
    
                        <fieldset>
                        <legend><h3>Información general</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-utensils'></i> Tipo de restaurante</h4>
                        <p>$tipo_restaurante</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-envelope'></i> Email</h4>
                        <p><a href='mailto:$email'>$email</a></p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-dollar-sign'></i> Costo</h4>
                        <p>$costo</p>
                        </fieldset>";
                    }else if(is_null($email) && !is_null($email)){
                        // ... (código para cuando falta el email)
                        echo "<fieldset>
                        <legend><h3>Información local</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-map-location-dot'></i> Dirección</h4>
                        <p>$direccion</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-location-dot'></i> Provincia</h4>
                        <p>$provincia</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-clock'></i> Horario</h4>
                        <p>$dia_apertura a $dia_cierre desde las $hora_apertura hrs. hasta las $hora_cierre hrs.</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-phone'></i> Teléfono</h4>
                        <p><a href='tel:+507$telefono'>+507 $telefono</a></p>
                        </fieldset>
    
                        <fieldset>
                        <legend><h3>Información general</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-utensils'></i> Tipo de restaurante</h4>
                        <p>$tipo_restaurante</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-laptop'></i> Sitio web</h4>
                        <p><a href='https://$sitio_web' target='_blank'>Visitar el sitio web</a></p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-dollar-sign'></i> Costo</h4>
                        <p>$costo</p>
                        </fieldset>";
                    }else if(is_null($sitio_web) && is_null($email)){
                        // ... (código para cuando faltan ambos)
                        echo "<fieldset>
                        <legend><h3>Información local</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-map-location-dot'></i> Dirección</h4>
                        <p>$direccion</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-location-dot'></i> Provincia</h4>
                        <p>$provincia</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-clock'></i> Horario</h4>
                        <p>$dia_apertura a $dia_cierre desde las $hora_apertura hrs. hasta las $hora_cierre hrs.</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-phone'></i> Teléfono</h4>
                        <p><a href='tel:+507$telefono'>+507 $telefono</a></p>
                        </fieldset>
    
                        <fieldset>
                        <legend><h3>Información general</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-utensils'></i> Tipo de restaurante</h4>
                        <p>$tipo_restaurante</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-dollar-sign'></i> Costo</h4>
                        <p>$costo</p>
                        </fieldset>";
                    }else{
                        // ... (código para cuando ambos están presentes)
                        echo "<fieldset>
                        <legend><h3>Información local</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-map-location-dot'></i> Dirección</h4>
                        <p>$direccion</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-location-dot'></i> Provincia</h4>
                        <p>$provincia</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-clock'></i> Horario</h4>
                        <p>$dia_apertura a $dia_cierre desde las $hora_apertura hrs. hasta las $hora_cierre hrs.</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-phone'></i> Teléfono</h4>
                        <p><a href='tel:+507$telefono'>+507 $telefono</a></p>
                        </fieldset>
    
                        <fieldset>
                        <legend><h3>Información general</h3></legend>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-utensils'></i> Tipo de restaurante</h4>
                        <p>$tipo_restaurante</p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-envelope'></i> Email</h4>
                        <p><a href='mailto:$email'>$email</a></p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-laptop'></i> Sitio web</h4>
                        <p><a href='https://$sitio_web' target='_blank'>Visitar el sitio web</a></p>
                        <h4><i class='fontawesome-restaurant-info fa-solid fa-dollar-sign'></i> Costo</h4>
                        <p>$costo</p>
                        </fieldset>";
                    }
                }
            }else{
                // Mostrar un mensaje si la sucursal no está registrada
                echo "<h4>La sucursal no está registrada</h4>";
            }
        }
    }

    function consultarPlatosRestaurante(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;
    
            // Obtener el parámetro de la URL
            $restaurante_id = intval($_GET["restaurante_id"]);
    
            // Consulta SQL para obtener los platos del restaurante
            $query = "SELECT platos.nombre, platos.descripcion, platos.precio, platos.nombre_foto FROM platos JOIN restaurantes ON platos.id_restaurante=restaurantes.id WHERE restaurantes.id=$restaurante_id";
    
            // Ejecutar la consulta
            $result = mysqli_query($conexion, $query);
    
            // Verificar si la consulta fue exitosa y si hay resultados
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            } else if(mysqli_num_rows($result) > 0){
                // Iterar sobre los resultados y mostrar la información de cada plato
                while ($row = mysqli_fetch_assoc($result)) {
                    // Extraer los datos de la fila
                    $nombre_plato = $row['nombre'];
                    $desc_plato = $row['descripcion'];
                    $precio_plato = $row['precio'];
                    $foto_plato = $row['nombre_foto'];
    
                    // Mostrar la información de cada plato en un formato específico
                    echo "<div class='restaurant-menu-col'>
                        <figure>
                            <img src='../assets/imgs/platos/$foto_plato.webp' alt='$nombre_plato' loading='lazy'/>
                            <figcaption>$nombre_plato</figcaption>
                        </figure>
    
                        <details>
                            <summary>Descripción</summary>
                            <p>$desc_plato</p>
                        </details>
    
                        <details>
                            <summary>Precio</summary>
                            <p>$precio_plato</p>
                        </details>
                    </div>";
                }
            }
        }
    }

    function restringirHorasReserva(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;
    
            // Obtener el parámetro de la URL
            $sucursal_id = intval($_GET["sucursal_id"]);
    
            // Consulta SQL para obtener las horas de apertura y cierre de la sucursal
            $query = "SELECT sucursales.hora_apertura, sucursales.hora_cierre FROM sucursales WHERE sucursales.id=$sucursal_id";
    
            // Ejecutar la consulta
            $result = mysqli_query($conexion, $query);
    
            // Verificar si la consulta fue exitosa y si hay resultados
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            } else if(mysqli_num_rows($result) > 0){
                // Iterar sobre los resultados y mostrar las horas de apertura y cierre
                while ($row = mysqli_fetch_assoc($result)) {
                    // Extraer los datos de la fila
                    $hora_apertura = $row['hora_apertura'];
                    $hora_cierre = $row['hora_cierre'];
    
                    // Imprimir atributos HTML para restringir las horas de reserva
                    echo "min='$hora_apertura' max='$hora_cierre'";
                }
            }
        }
    }

    function imprimirUrlInfoRestaurante(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;
        
            // Obtener los parámetros de la URL
            $restaurante_id = intval($_GET["restaurante_id"]);
            $sucursal_id = intval($_GET["sucursal_id"]);
            $tipo_restaurante = mysqli_real_escape_string($conexion, $_GET["tipo_restaurante"]);
    
            // Construir la URL con los parámetros
            echo "restaurant_info.php?restaurante_id=$restaurante_id&sucursal_id=$sucursal_id&tipo_restaurante=$tipo_restaurante";
        }
    }

    function crearReserva(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;

            // Obtener los parámetros de la URL
            $sucursal_id=intval($_GET["sucursal_id"]);
            $restaurante_id=intval($_GET["restaurante_id"]);

            // Verificar si hay datos en el formulario ($_POST)
            if($_POST){
                // Verificar si el usuario ha iniciado sesión
                if(isset($_SESSION["id_usuario"])){
                    // Obtener datos del formulario
                    $fecha=mysqli_real_escape_string($conexion,$_POST["txtReservationDate"]);
                    $hora=mysqli_real_escape_string($conexion,$_POST["txtReservationHour"]);
                    $personas=mysqli_real_escape_string($conexion,$_POST["txtReservationPeoples"]);
                    $comentario=trim(mysqli_real_escape_string($conexion,$_POST["txtReservationComment"]));
                    $usuario_id=$_SESSION["id_usuario"];

                    // Validar que el campo de comentario no esté vacío
                    if($comentario===""){
                        echo "<script>
                            // Mostrar alerta de error
                            Swal.fire({
                                title: 'Oops...',
                                text: '¡No se admiten campos vacíos!',
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    confirmButton: 'custom-swal-button'
                                }
                            });
                        </script>";
                    }else{
                        // Verificar si el restaurante tiene menú para niños
                        $query = "SELECT restaurantes.tiene_menu_ninnios FROM restaurantes WHERE restaurantes.id=$restaurante_id";
                        $result=mysqli_query($conexion,$query);
        
                        if (!$result) {
                          die("Error en la consulta: " . mysqli_error($conexion));
                        }else{
                            $row = mysqli_fetch_assoc($result);
                        
                            // Verificar si el restaurante tiene menú para niños
                            if($row && $row['tiene_menu_ninnios'] === 'si'){
                                $sillas_ninnios=mysqli_real_escape_string($conexion,$_POST["txtReservationChildrenChair"]);
                                $query="INSERT INTO `reservas`(`fecha`,`hora`,`numero_personas`,`sillas_ninnios`,`comentario`,`id_usuario`,`id_sucursal`) VALUES ('$fecha','$hora','$personas','$sillas_ninnios','$comentario','$usuario_id','$sucursal_id')";
                            }else{
                                $query="INSERT INTO `reservas`(`fecha`,`hora`,`numero_personas`,`comentario`,`id_usuario`,`id_sucursal`) VALUES ('$fecha','$hora','$personas','$comentario','$usuario_id','$sucursal_id')";
                            }
    
                            $result=mysqli_query($conexion,$query);
    
                            if ($result) {            
                                // Mostrar alerta de éxito y redirigir después de un tiempo
                                echo '<script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "¡La reserva se ha registrado correctamente!",
                                        showConfirmButton: false,
                                        timer: 3000
                                    }).then(() => {
                                        window.location.href = "home.php";
                                    });
                                </script>';
                            }else{
                                die('La inserción de los datos ha fallado!'. mysqli_error($conexion));
                            }
                        }
                    }
                }
            }
        }
    }

    function validarMenuNinnios(){
        // Verificar si hay parámetros en la URL ($_GET)
        if($_GET){
            global $conexion;

            // Obtener el parámetro de la URL
            $restaurante_id=intval($_GET["restaurante_id"]);

            // Consultar si el restaurante tiene menú para niños
            $query = "SELECT restaurantes.tiene_menu_ninnios FROM restaurantes WHERE restaurantes.id=$restaurante_id";
            $result=mysqli_query($conexion,$query);

            // Verificar si hay errores en la consulta
            if (!$result) {
              die("Error en la consulta: " . mysqli_error($conexion));
            }else{
                $row=mysqli_fetch_assoc($result);

                // Verificar si el restaurante tiene menú para niños
                if($row && $row['tiene_menu_ninnios'] === 'si'){
                    // Mostrar el campo de entrada para las sillas de niños
                    echo "<p>
                        <label for='reservation-children-chair'>Sillas para niños:</label>
                        <input
                        type='number'
                        name='txtReservationChildrenChair'
                        id='reservation-children-chair'
                        min='0'
                        max='10'
                        required
                        />
                    </p>";
                }
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
        }
    }

    function consultarReservasProximas(){
        // Establecer la conexión global a la base de datos
        global $conexion;

        // Verificar si hay una sesión de usuario iniciada
        if(isset($_SESSION["id_usuario"])){
            // Obtener el ID del usuario de la sesión
            $usuario_id=$_SESSION["id_usuario"];

            // Consultar las reservas del usuario
            $query="SELECT id, fecha, hora, numero_personas, sillas_ninnios, comentario, id_sucursal FROM reservas WHERE id_usuario=$usuario_id";
            $result=mysqli_query($conexion,$query);

            // Verificar si hay errores en la consulta
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            }else if(mysqli_num_rows($result) > 0){
                // Recorrer las filas de resultado
                while ($row=mysqli_fetch_assoc($result)) {
                    // Obtener datos de la reserva
                    $reserva_id=$row['id'];
                    $fecha=$row['fecha'];
                    $hora=$row['hora'];
                    $personas=$row['numero_personas'];
                    $sillas_ninnios=$row['sillas_ninnios'];
                    $comentario=$row['comentario'];
                    $sucursal_id=$row['id_sucursal'];

                    // Crear un objeto de fecha y hora
                    $fechaHora="$fecha $hora:00";
                    $zonaHoraria=new DateTimeZone('America/Panama');
                    $objFechaHora=DateTime::createFromFormat('Y-m-d H:i:s', $fechaHora, $zonaHoraria);
                    $fechaHoraHoy=new DateTime('now', $zonaHoraria);

                    // Verificar si la fecha y hora de la reserva son futuras
                    if($objFechaHora >= $fechaHoraHoy){
                        // Consultar información de la sucursal asociada a la reserva
                        $querySucursal="SELECT restaurantes.nombre, sucursales.provincia, sucursales.direccion FROM sucursales JOIN restaurantes ON sucursales.id_restaurante=restaurantes.id WHERE sucursales.id=$sucursal_id";
                        $resultSucursal=mysqli_query($conexion,$querySucursal);

                        // Verificar si hay errores en la consulta de la sucursal
                        if(!$resultSucursal){
                            die("Error en la consulta: " . mysqli_error($conexion));  
                        }else{
                            $rowSucursal=mysqli_fetch_assoc($resultSucursal);

                            // Obtener datos de la sucursal
                            $nombre=$rowSucursal['nombre'];
                            $provincia=$rowSucursal['provincia'];
                            $direccion=$rowSucursal['direccion'];

                            // Mostrar la información de la reserva
                            echo "<form id='reservation-info-form'>
                                <h3 class='block-grid-reservation'>$nombre - $direccion, $provincia</h3>
                                <p>
                                    <label>Fecha deseada:</label>
                                    <input
                                        type='date'
                                        value='$fecha'
                                        readonly
                                    />
                                </p>
                                <p>
                                    <label>Hora deseada:</label>
                                    <input
                                        type='time'
                                        value='$hora'
                                        readonly
                                    />
                                </p>
                                <p>
                                    <label>Número de personas:</label>
                                    <input
                                        type='number'
                                        value='$personas'
                                        readonly
                                    />
                                </p>";

                                // Mostrar el campo de sillas para niños si está presente
                                if(!is_null($sillas_ninnios)){
                                    echo "<p>
                                        <label>Sillas para niños:</label>
                                        <input
                                            type='number'
                                            value='$sillas_ninnios'
                                            readonly
                                        />
                                    </p>";
                                }
                        
                                echo "<p class='block-grid-reservation'>
                                    <label>Comentario adicional:</label>
                                    <br />
                                    <textarea
                                        cols='10'
                                        rows='3'
                                        readonly
                                    >$comentario</textarea>
                                </p>
                                <p>
                                    <a href='modify_reservation.php?reserva_id=$reserva_id'>
                                        Modificar
                                    </a>
                                </p>
                                <p>
                                    <a href='reservation_info.php?reserva_id=$reserva_id'>
                                        Eliminar
                                    </a>
                                </p>
                            </form>";
                        }
                    }
                }
            }else{
                // Mostrar mensaje si no hay reservas registradas para el usuario
                echo "<h4>No se ha registrado ninguna reserva</h4>";
            }
        }
    }

    function consultarReservasCompletadas(){
        // Establecer la conexión global a la base de datos
        global $conexion;

        // Verificar si hay una sesión de usuario iniciada
        if(isset($_SESSION["id_usuario"])){
            // Obtener el ID del usuario de la sesión
            $usuario_id=$_SESSION["id_usuario"];

            // Consultar las reservas del usuario
            $query="SELECT fecha, hora, numero_personas, sillas_ninnios, comentario, id_sucursal FROM reservas WHERE id_usuario=$usuario_id";
            $result=mysqli_query($conexion,$query);

            // Verificar si hay errores en la consulta
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            }else if(mysqli_num_rows($result) > 0){
                // Recorrer las filas de resultado
                while ($row=mysqli_fetch_assoc($result)) {
                    // Obtener datos de la reserva
                    $fecha=$row['fecha'];
                    $hora=$row['hora'];
                    $personas=$row['numero_personas'];
                    $sillas_ninnios=$row['sillas_ninnios'];
                    $comentario=$row['comentario'];
                    $sucursal_id=$row['id_sucursal'];

                    // Crear un objeto de fecha y hora
                    $fechaHora="$fecha $hora:00";
                    $zonaHoraria=new DateTimeZone('America/Panama');
                    $objFechaHora=DateTime::createFromFormat('Y-m-d H:i:s', $fechaHora, $zonaHoraria);
                    $fechaHoraHoy=new DateTime('now', $zonaHoraria);

                    // Verificar si la fecha y hora de la reserva son pasadas
                    if($objFechaHora < $fechaHoraHoy){
                        // Consultar información de la sucursal asociada a la reserva
                        $querySucursal="SELECT restaurantes.nombre, sucursales.provincia, sucursales.direccion FROM sucursales JOIN restaurantes ON sucursales.id_restaurante=restaurantes.id WHERE sucursales.id=$sucursal_id";
                        $resultSucursal=mysqli_query($conexion,$querySucursal);

                        // Verificar si hay errores en la consulta de la sucursal
                        if(!$resultSucursal){
                            die("Error en la consulta: " . mysqli_error($conexion));  
                        }else{
                            $rowSucursal=mysqli_fetch_assoc($resultSucursal);

                            // Obtener datos de la sucursal
                            $nombre=$rowSucursal['nombre'];
                            $provincia=$rowSucursal['provincia'];
                            $direccion=$rowSucursal['direccion'];

                            // Mostrar la información de la reserva
                            echo "<form id='reservation-info-form'>
                                <h3 class='block-grid-reservation'>$nombre - $direccion, $provincia</h3>
                                <p>
                                    <label>Fecha deseada:</label>
                                    <input
                                        type='date'
                                        value='$fecha'
                                        readonly
                                    />
                                </p>
                                <p>
                                    <label>Hora deseada:</label>
                                    <input
                                        type='time'
                                        value='$hora'
                                        readonly
                                    />
                                </p>
                                <p>
                                    <label>Número de personas:</label>
                                    <input
                                        type='number'
                                        value='$personas'
                                        readonly
                                    />
                                </p>";
                                // Mostrar el campo de sillas para niños si está presente
                                if(!is_null($sillas_ninnios)){
                                    echo "<p>
                                        <label>Sillas para niños:</label>
                                        <input
                                            type='number'
                                            value='$sillas_ninnios'
                                            readonly
                                        />
                                    </p>";
                                }
                                echo "<p class='block-grid-reservation'>
                                    <label>Comentario adicional:</label>
                                    <br />
                                    <textarea
                                        cols='10'
                                        rows='3'
                                        readonly
                                    >$comentario</textarea>
                                </p>
                            </form>";
                        }
                    }
                }
            }else{
                // Mostrar mensaje si no hay reservas registradas para el usuario
                echo "<h4>No se ha registrado ninguna reserva</h4>";
            }
        }
    }

    function eliminarReserva(){
        // Verificar si se ha enviado una solicitud GET
        if($_GET){
            global $conexion;

            // Obtener el ID de la reserva de la solicitud GET
            $reserva_id=intval($_GET["reserva_id"]);
            
            // Verificar si hay una sesión de usuario iniciada
            if(isset($_SESSION["id_usuario"])){
                $usuario_id=$_SESSION["id_usuario"];

                // Construir la consulta SQL para eliminar la reserva
                $query="DELETE FROM reservas WHERE id='$reserva_id' AND id_usuario='$usuario_id'";
                // Ejecutar la consulta
                $result=mysqli_query($conexion,$query);

                // Verificar si la eliminación fue exitosa
                if (!$result) {
                    // Mostrar un mensaje de error si la eliminación falla
                    die('La eliminación de la fila ha fallado '. mysqli_error());
                }else{
                    // Mostrar alerta de éxito y redirigir después de un tiempo
                    echo "<script>
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: '¡La reserva se eliminó exitosamente!',
                            showConfirmButton: false,
                            timer: 3000 
                        }).then(() => {
                            window.location.href = 'reservation_info.php';
                        });
                    </script>";
                }

                // Cerrar la conexión a la base de datos al final de la función
                mysqli_close($conexion);
            }
        }
    }

    function consultarReserva(){
        // Verificar si se ha enviado una solicitud GET
        if($_GET){
            // Establecer la conexión global a la base de datos
            global $conexion;

            // Obtener el ID de la reserva de la solicitud GET
            $reserva_id=intval($_GET["reserva_id"]);
    
            // Verificar si hay una sesión de usuario iniciada
            if(isset($_SESSION["id_usuario"])){
                // Obtener el ID de usuario de la sesión
                $usuario_id=$_SESSION["id_usuario"];

                // Consultar la información de la reserva para el usuario actual
                $query="SELECT fecha, hora, numero_personas, sillas_ninnios, comentario, id_sucursal FROM reservas WHERE id_usuario=$usuario_id AND id=$reserva_id";
                $result=mysqli_query($conexion,$query);
        
                // Verificar si hay errores en la consulta
                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                }else if(mysqli_num_rows($result) > 0){
                    // Recorrer las filas de resultado
                    while ($row=mysqli_fetch_assoc($result)) {
                        // Obtener datos de la reserva
                        $fecha=$row['fecha'];
                        $hora=$row['hora'];
                        $personas=$row['numero_personas'];
                        $sillas_ninnios=$row['sillas_ninnios'];
                        $comentario=$row['comentario'];
                        $sucursal_id=$row['id_sucursal'];
    
                        // Obtener la fecha mínima permitida (hoy)
                        $zonaHoraria = new DateTimeZone('America/Panama');
                        $fechaMinima = (new DateTime('now', $zonaHoraria))->format('Y-m-d');
                        
                        // Consultar información de la sucursal asociada a la reserva
                        $querySucursal="SELECT restaurantes.nombre, sucursales.provincia, sucursales.direccion, sucursales.hora_apertura, sucursales.hora_cierre FROM sucursales JOIN restaurantes ON sucursales.id_restaurante=restaurantes.id WHERE sucursales.id=$sucursal_id";
                        $resultSucursal=mysqli_query($conexion,$querySucursal);
    
                        // Verificar si hay errores en la consulta de la sucursal
                        if(!$resultSucursal){
                            die("Error en la consulta: " . mysqli_error($conexion));  
                        }else{
                                $rowSucursal=mysqli_fetch_assoc($resultSucursal);
    
                                // Obtener datos de la sucursal
                                $nombre=$rowSucursal['nombre'];
                                $provincia=$rowSucursal['provincia'];
                                $direccion=$rowSucursal['direccion'];
                                $hora_apertura=$rowSucursal['hora_apertura'];
                                $hora_cierre=$rowSucursal['hora_cierre'];
    
                                // Mostrar el formulario de modificación de reserva
                                echo "<form action='modify_reservation.php?reserva_id=$reserva_id' method='post' id='reservation-info-form'>
                                    <h3 class='block-grid-reservation'>$nombre - $direccion, $provincia</h3>
                                    <p>
                                        <label for='reservation-date'>Fecha deseada:</label>
                                        <input
                                            type='date'
                                            name='txtReservationDate'
                                            id='reservation-date'
                                            value='$fecha'
                                            min='$fechaMinima'
                                            autofocus
                                            required
                                        />
                                    </p>
                                    <p>
                                        <label for='reservation-hour'>Hora deseada:</label>
                                        <input
                                            type='time'
                                            name='txtReservationHour'
                                            id='reservation-hour'
                                            value='$hora'
                                            step='900'
                                            min='$hora_apertura'
                                            max='$hora_cierre'
                                            required
                                        />
                                    </p>
                                    <p>
                                        <label for='reservation-peoples'>Número de personas:</label>
                                        <input
                                            type='number'
                                            name='txtReservationPeoples'
                                            id='reservation-peoples'
                                            value='$personas'
                                            min='1'
                                            max='10'
                                            required
                                        />
                                    </p>";
                                    // Mostrar el campo de sillas para niños si está presente
                                    if(!is_null($sillas_ninnios)){
                                        echo "<p>
                                            <label for='reservation-children-chair'>Sillas para niños:</label>
                                            <input
                                                type='number'
                                                name='txtReservationChildrenChair'
                                                id='reservation-children-chair'
                                                value='$sillas_ninnios'
                                                min='0'
                                                max='10'
                                                required
                                            />
                                        </p>";
                                    }
                                    echo "<p class='block-grid-reservation'>
                                        <label for='comment'>Comentario adicional:</label>
                                        <textarea
                                        name='txtReservationComment'
                                        id='comment'
                                        cols='10'
                                        rows='3'
                                        required>$comentario</textarea>
                                    </p>
                                    <p class='block-grid-reservation'>
                                        <button>
                                            Modificar
                                        </button>
                                    </p>
                                </form>";
                            }
                    }
                }else{
                    // Mostrar mensaje si la reserva no está registrada para el usuario
                    echo "<h4>La reserva no está registrada</h4>";
                }
            }
        }
    }

    function modificarReserva(){
        // Verificar si se ha enviado una solicitud GET
        if($_GET){
            // Obtener el ID de la reserva de la solicitud GET
            $reserva_id=intval($_GET["reserva_id"]);

            // Verificar si se ha enviado una solicitud POST
            if($_POST){
                // Establecer la conexión a la base de datos
                global $conexion;
    
                // Verificar si hay una sesión de usuario iniciada
                if(isset($_SESSION["id_usuario"])){
                    // Obtener datos del formulario
                    $fecha=mysqli_real_escape_string($conexion,$_POST["txtReservationDate"]);
                    $hora=mysqli_real_escape_string($conexion,$_POST["txtReservationHour"]);
                    $personas=mysqli_real_escape_string($conexion,$_POST["txtReservationPeoples"]);
                    $comentario=trim(mysqli_real_escape_string($conexion,$_POST["txtReservationComment"]));
                    $usuario_id=$_SESSION["id_usuario"];
    
                    // Validar que el campo de comentario no esté vacío
                    if($comentario===""){
                        echo "<script>
                            // Mostrar alerta de error
                            Swal.fire({
                                title: 'Oops...',
                                text: '¡No se admiten campos vacíos!',
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                                customClass:{
                                    confirmButton: 'custom-swal-button'
                                }
                            });
                        </script>";
                    }else{
                        // Verificar si se ha enviado un valor para el input de sillas para niños
                        if(isset($_POST['txtReservationChildrenChair'])){
                            $sillas_ninnios=mysqli_real_escape_string($conexion,$_POST['txtReservationChildrenChair']);
                            $query="UPDATE reservas SET fecha='$fecha',hora='$hora',numero_personas='$personas',sillas_ninnios='$sillas_ninnios',comentario='$comentario' WHERE id_usuario='$usuario_id' AND id='$reserva_id'";
                        }else{
                            $query="UPDATE reservas SET fecha='$fecha',hora='$hora',numero_personas='$personas',comentario='$comentario' WHERE id_usuario='$usuario_id' AND id='$reserva_id'";
                        }
                       
                        // Ejecutar la consulta de actualización
                        $result=mysqli_query($conexion,$query);

                        // Verificar si la actualización fue exitosa
                        if ($result) {
                            // Mostrar alerta de éxito y redirigir después de un tiempo
                            echo "<script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: '¡La reserva se modificó exitosamente!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    window.location.href = 'reservation_info.php';
                                });
                            </script>";
                        }else{
                            // Mostrar mensaje de error si la actualización falla
                            die("La inserción de los datos ha fallado!". mysqli_error($conexion));
                        }
                    }
                }

                // Cerrar la conexión a la base de datos al final de la función
                mysqli_close($conexion);
            }
        }
    }

    function imprimirFiltros(){
        // Verifica si hay datos en la variable $_POST
        if($_POST){
            // Verifica si el campo txtFoodType no está vacío en $_POST
            if(!empty($_POST['txtFoodType'])){
                // Obtiene y muestra el tipo de comida seleccionado
                $tipo_comida=$_POST['txtFoodType'];
                echo "<li>$tipo_comida</li>";
            }
            // Verifica si el campo txtProvince no está vacío en $_POST
            if(!empty($_POST['txtProvince'])){
                // Obtiene y muestra la provincia seleccionada
                $provincia=$_POST['txtProvince'];
                echo "<li>$provincia</li>";
            }
            // Verifica si el campo txtCost no está vacío en $_POST
            if(!empty($_POST['txtCost'])){
                // Obtiene y muestra el costo seleccionado
                $costo=$_POST['txtCost'];
                echo "<li>$costo</li>";
            }
            // Verifica si el campo txtFacilities está definido, es un array y no está vacío en $_POST
            if (isset($_POST['txtFacilities']) && is_array($_POST['txtFacilities']) && !empty($_POST['txtFacilities'])) {
                // Obtiene y muestra cada facilidad seleccionada
                $facilidades=$_POST['txtFacilities'];

                foreach($facilidades as $facilidad){
                    echo "<li>$facilidad</li>";
                };
            }
        }
    }

    function buscarRestaurantes(){
        // Verifica si hay datos en la variable $_GET
        if($_GET){
            global $conexion;
            // Escapa el valor del parámetro tipo_restaurante para prevenir SQL injection
            $tipo_restaurante=mysqli_real_escape_string($conexion,$_GET["tipo_restaurante"]);

            // Verifica si hay datos en la variable $_POST
            if($_POST){
                // Construye la parte principal de la consulta SQL
                $query="SELECT restaurantes.id AS id_restaurante, restaurantes.nombre AS nombre, sucursales.id AS id_sucursal, sucursales.provincia AS provincia, sucursales.direccion AS direccion, sucursales.hora_apertura AS hora_apertura, sucursales.hora_cierre AS hora_cierre, fotos_restaurantes.nombre AS foto FROM sucursales JOIN restaurantes ON sucursales.id_restaurante=restaurantes.id JOIN fotos_restaurantes ON restaurantes.id=fotos_restaurantes.id_restaurante WHERE restaurantes.tipo_restaurante='$tipo_restaurante'";
                
                // Verifica y agrega condiciones adicionales según los datos en $_POST
                if(!empty($_POST['txtFoodType'])){
                    $tipo_comida=mysqli_real_escape_string($conexion,$_POST['txtFoodType']);
                    $query.=" AND restaurantes.tipo_comida='$tipo_comida'";
                }
                if(!empty($_POST['txtProvince'])){
                    $provincia=mysqli_real_escape_string($conexion,$_POST['txtProvince']);
                    $query.=" AND sucursales.provincia='$provincia'";
                }
                if(!empty($_POST['txtCost'])){
                    $costo=mysqli_real_escape_string($conexion,$_POST['txtCost']);
                    $query.=" AND restaurantes.costo='$costo'";
                }
                if (isset($_POST['txtFacilities']) && is_array($_POST['txtFacilities']) && !empty($_POST['txtFacilities'])) {
                    $facilidades=$_POST['txtFacilities'];

                    foreach($facilidades as $facilidad){
                        // Agrega condiciones basadas en las facilidades seleccionadas
                        if($facilidad==="Menú de niños"){
                            $query.=" AND restaurantes.tiene_menu_ninnios='si'";
                        }elseif($facilidad==="Silla de bebé"){
                            $query.=" AND restaurantes.tiene_silla_bebe='si'";
                        }elseif($facilidad==="Cambiador"){
                            $query.=" AND restaurantes.tiene_cambiador='si'";
                        }elseif($facilidad==="Accesibilidad para discapacitados"){
                            $query.=" AND restaurantes.accesibilidad_discapacitados='si'";
                        }elseif($facilidad==="Parking"){
                            $query.=" AND restaurantes.tiene_parking='si'";
                        }
                    };
                }

                // Finaliza la consulta y agrupa los resultados por dirección
                $query.=" GROUP BY sucursales.direccion";
                // Ejecuta la consulta SQL
                $result = mysqli_query($conexion, $query);

                // Verifica si la consulta fue exitosa
                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                } else if(mysqli_num_rows($result) > 0){
                    // Itera sobre los resultados y muestra la información
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Extrae información del restaurante
                        $restaurante_id = $row["id_restaurante"];
                        $nombre = $row["nombre"];
                        $sucursal_id = $row["id_sucursal"];
                        $provincia = $row["provincia"];
                        $direccion = $row["direccion"];
                        $hora_apertura = $row["hora_apertura"];
                        $hora_cierre = $row["hora_cierre"];
                        $foto = $row["foto"];

                        // Muestra la información del restaurante
                        echo "<a href='restaurant_info.php?restaurante_id=$restaurante_id&sucursal_id=$sucursal_id&tipo_restaurante=$tipo_restaurante' class='restaurantes-search-col'>
                            <figure>
                                <img
                                    src='../assets/imgs/restaurantes/$foto.webp'
                                    alt='$nombre'
                                    loading='lazy'
                                />
                                <figcaption>$nombre</figcaption>
                                <p><i class='fa-solid fa-location-dot'></i> $provincia - $direccion</p>
                                <div>
                                    <p><i class='fa-regular fa-clock'></i> $hora_apertura - $hora_cierre</p>
                                </div>
                            </figure>
                        </a>";
                    }
                }else{
                    // Mensaje si no se encontraron resultados
                    echo "<h4>No se encontraron resultados</h4>";
                }
            }else{
                // Si no hay datos en $_POST, realiza una consulta simplificada sin condiciones adicionales
                $query="SELECT restaurantes.id AS id_restaurante, restaurantes.nombre AS nombre, sucursales.id AS id_sucursal, sucursales.provincia AS provincia, sucursales.direccion AS direccion, sucursales.hora_apertura AS hora_apertura, sucursales.hora_cierre AS hora_cierre, fotos_restaurantes.nombre AS foto FROM sucursales JOIN restaurantes ON sucursales.id_restaurante=restaurantes.id JOIN fotos_restaurantes ON restaurantes.id=fotos_restaurantes.id_restaurante WHERE restaurantes.tipo_restaurante='$tipo_restaurante' GROUP BY sucursales.direccion";
                $result = mysqli_query($conexion, $query);
    
                // Verificar si la consulta fue exitosa
                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                } else if(mysqli_num_rows($result) > 0){
                    // Itera sobre los resultados y muestra la información
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Extrae información del restaurante
                        $restaurante_id = $row["id_restaurante"];
                        $nombre = $row["nombre"];
                        $sucursal_id = $row["id_sucursal"];
                        $provincia = $row["provincia"];
                        $direccion = $row["direccion"];
                        $hora_apertura = $row["hora_apertura"];
                        $hora_cierre = $row["hora_cierre"];
                        $foto = $row["foto"];

                        // Muestra la información del restaurante
                        echo "<a href='restaurant_info.php?restaurante_id=$restaurante_id&sucursal_id=$sucursal_id&tipo_restaurante=$tipo_restaurante' class='restaurantes-search-col'>
                            <figure>
                                <img
                                    src='../assets/imgs/restaurantes/$foto.webp'
                                    alt='$nombre'
                                    loading='lazy'
                                />
                                <figcaption>$nombre</figcaption>
                                <p><i class='fa-solid fa-location-dot'></i> $provincia - $direccion</p>
                                <div>
                                    <p><i class='fa-regular fa-clock'></i> $hora_apertura - $hora_cierre</p>
                                </div>
                            </figure>
                        </a>";
                    }
                }else{
                    // Mensaje si no hay restaurantes del tipo especificado
                    echo "<h4>No hay $tipo_restaurante en la BD</h4>";
                }
            }

            // Cerrar la conexión a la base de datos al final de la función
            mysqli_close($conexion);
        }
    }
?>