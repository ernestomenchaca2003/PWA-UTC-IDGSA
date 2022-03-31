<?php
session_start();
require '../config/conexion.php';
if (isset($_POST['enviar_mensaje'])) {
    $id = $_GET['id_usuario'];
    $admin = 'Admin';
    $nombre = $_POST['nombre'];
    $mensaje = $_POST['mensaje'];
    $insertar_mensaje = "INSERT INTO mensajes (mensaje_from, mensaje_to, mensaje) VALUES ('$admin', '$nombre', '$mensaje')";
    $ejecutar_query = mysqli_query($conexion, $insertar_mensaje) or die(mysqli_error($conexion));
    if ($ejecutar_query) {
        echo "<script>alert('Mensaje enviado correctamente')</script>";
        echo "<script>window.location='../view/Administradores/index.php?id_usuario=$id'</script>";
    }else{

    }
}

if(isset($_POST['eliminar'])){
    $id = $_GET['id_usuario'];
    $id_mensaje = $_GET['id_mensaje'];
    $eliminar_mensaje = "DELETE FROM mensajes WHERE mensaje_id = $id_mensaje";
    $ejecutar_query = mysqli_query($conexion, $eliminar_mensaje) or die(mysqli_error($conexion));
    if($ejecutar_query){
        echo "<script>alert('Mensaje eliminado correctamente')</script>";
        echo "<script>window.location='../view/Clientes/index.php?id_usuario=$id'</script>";
    }else{

    }
}
