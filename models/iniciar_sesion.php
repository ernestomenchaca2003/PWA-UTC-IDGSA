<?php
session_start();
$usuario = $_POST['nickname_usuario'];
$password = $_POST['password_usuario'];

require '../config/conexion.php';
$buscar_usuario = "SELECT * FROM usuarios WHERE nickname_usuario='$usuario' AND password_usuario='$password'";

$ejecutar_queryBusqueda = mysqli_query($conexion, $buscar_usuario) or die(mysqli_error($conexion));
$resultado_usuario = mysqli_fetch_assoc($ejecutar_queryBusqueda);

if ($resultado_usuario['tipo_usuario'] == 'admin') {
    $_SESSION['usuario' . $resultado_usuario['id_usuario']] = $usuario;
    header("Location: ../view/Administradores/?id_usuario={$resultado_usuario['id_usuario']}");
} elseif ($resultado_usuario['tipo_usuario'] == 'cliente') {
    $_SESSION['usuario' . $resultado_usuario['id_usuario']] = $usuario;
    header("Location: ../view/Clientes/?id_usuario={$resultado_usuario['id_usuario']}");
} else {
    echo '<script> alert("Usuario o contraseña incorrectos")</script>
    <script> window.location="../"</script>';
}
