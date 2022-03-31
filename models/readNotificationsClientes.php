<?php

include '../config/conexion.php';

$sql = "UPDATE mensajes SET estado = 1";
$ejecutar = mysqli_query($conexion, $sql);
if ($ejecutar) {
    echo 'Success';
} else {
    echo 'Failed';
}