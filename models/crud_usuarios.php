<?php
session_start();
require '../config/conexion.php';
if (isset($_POST['registro_usuario'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $nickname_usuario = $_POST['nickname_usuario'];
    $password_usuario = $_POST['password_usuario'];
    $tipo_usuario = 'cliente';
    $membresia = 'basica';
    $buscar_usuario = "SELECT * FROM usuarios WHERE nickname_usuario = '$nickname_usuario'";
    $resultado_usuario = mysqli_query($conexion, $buscar_usuario);
    if ($usuario_existe = mysqli_fetch_array($resultado_usuario) > 0) {
        echo '<script> alert("El usuario ya existe")</script>
        <script> window.location="../"</script>';
    } else {
        $query = "INSERT INTO usuarios(nombre_usuario, nickname_usuario, password_usuario,tipo_usuario,membresia) VALUES('$nombre_usuario', '$nickname_usuario', '$password_usuario','$tipo_usuario','$membresia')";
        $result = mysqli_query($conexion, $query);
        if ($result) {
            echo '<script> alert("Usuario registrado")</script>
            <script> window.location="../"</script>';
        } else {
            echo '<script> alert("Error al registrar")</script>
            <scipt> window.location="../"</script>';
        }
    }
}

if (isset($_POST['actualizar_usuario'])) {
    $id = $_GET['id_usuario'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_usuario = $_POST['correo_usuario'];
    $password_usuario = $_POST['password_usuario'];
    $actualizar_datos = "UPDATE usuarios SET nombre_usuario = '$nombre_usuario', correo_usuario = '$correo_usuario', password_usuario = '$password_usuario' WHERE id_usuario = $id";
    $resultado = mysqli_query($conexion, $actualizar_datos);
    if ($resultado) {
        echo '<script> alert("Usuario actualizado")</script>';
        header('Location: ../view/Clientes/?id_usuario='.$id);
    } else {
        echo '<script> alert("Error al actualizar")</script>';
        header('Location: ../view/Clientes/?id_usuario='.$id);
    }
}
