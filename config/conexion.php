<?php
$conexion = mysqli_connect('localhost', 'root', '');
if (!$conexion){
    die("No es posible conectarse a la base de datos 'innova_software'" . mysqli_error($conexion));
}
$select_db = mysqli_select_db($conexion, 'innova_software');
if (!$select_db){
    die("Error al buscar la base de datos 'innova_software'" . mysqli_error($conexion));
}
