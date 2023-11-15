<?php
    $conexion=mysqli_connect("localhost:3307","root","UG[dh]Zq.RyDa6dh","flavor-hunt");

    if($conexion){
        // echo "Conexion a la base de datos exitosa!";
    }else{
        die("La conexion a la base de datos ha fallado!");
    }
?>