<?php
    // Inicia o reanuda la sesión
    session_start();
    // Destruye todos los datos asociados con la sesión actual
    session_destroy();

    // Redirige al usuario a la página de inicio de sesión (login.php)
    header("Location: login.php");
    // Detiene la ejecución del script
    exit();
?>