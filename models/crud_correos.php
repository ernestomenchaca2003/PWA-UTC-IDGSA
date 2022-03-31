<?php
session_start();
require '../config/conexion.php';

if (isset($_POST['enviar_contacto'])) {
    $nombre = $_POST['nombre_contacto'];
    $correo = $_POST['correo_contacto'];
    $mensaje = $_POST['mensaje_contacto'];

    $sql = "INSERT INTO contactos (nombre_contacto, correo_contacto, mensaje_contacto) VALUES ('$nombre', '$correo', '$mensaje')";
    $ejecutar = mysqli_query($conexion, $sql);
    if ($ejecutar) {
        echo '<script> alert("Mensaje enviado correctamente")</script>
        <script> window.location="../"</script>';
    } else {
        echo '<script> alert("Error al enviar el mensaje")</script>
        <script> window.location="../"</script>';
    }
}
if(isset($_POST['eliminar_buzon'])){
    $id = $_GET['contacto_id'];
    $id_usuario = $_GET['id_usuario'];
    $sql = "DELETE FROM contactos WHERE contacto_id = $id";
    $ejecutar = mysqli_query($conexion, $sql);
    if($ejecutar){
        header('Location: ../view/Administradores/?id_usuario='.$id_usuario);
    }else{
        echo '<script> alert("Error al eliminar el mensaje")</script>';
        header('Location: ../view/Administradores/?id_usuario='.$id_usuario);
    }
}
