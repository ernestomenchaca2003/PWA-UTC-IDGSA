<?php
session_start();
require '../../config/conexion.php';
$id = $_GET['id_usuario'];
$usuario = $_SESSION['usuario' . $id];
if (isset($_SESSION['usuario' . $id])) {
} else {
    echo '<script> alert("Error: NO INGRESASTE TUS CREDENCIALES")</script>
    <script> window.location="../../"</script>';
}

$buscar_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id";
$ejecutar_queryBusqueda = mysqli_query($conexion, $buscar_usuario) or die(mysqli_error($conexion));
$resultado_usuario = mysqli_fetch_array($ejecutar_queryBusqueda);

$notificacion_mensaje = "SELECT * FROM contactos WHERE estado = 0  ORDER BY contacto_id DESC  limit 5";
$ejecutar_queryNotificacion = mysqli_query($conexion, $notificacion_mensaje) or die(mysqli_error($conexion));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" href="../../public/icons/codigo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <title>Administrador</title>
</head>

<body style="overflow-x: hidden;">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="#"><?php echo $resultado_usuario['nombre_usuario'] ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="" id="notifications"><img src="../../public/icons/notification.png" alt="" style="margin-right: -15px;">
                        <span class="count" style="background-color: red; color: white;border-radius: 5px; position:relative"><?php echo mysqli_num_rows($ejecutar_queryNotificacion) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../models/cerrar_sesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <center>
                <h3>Buzón de Mensajes</h3>
            </center>
            <?php

            if (mysqli_num_rows($ejecutar_queryNotificacion) > 0) {
                foreach ($ejecutar_queryNotificacion as $notificacion) {
            ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert alert-success" role="alert">
                            <?php echo $notificacion['nombre_contacto'] ?> te ha enviado un mensaje
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

            <?php
                }
            }
            ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Mensaje</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buscar_mensajes = "SELECT * FROM contactos ORDER BY contacto_id DESC limit 10";
                    $ejecutar_queryBusqueda = mysqli_query($conexion, $buscar_mensajes) or die(mysqli_error($conexion));
                    while ($resultado_mensajes = mysqli_fetch_array($ejecutar_queryBusqueda)) {
                    ?>
                        <tr>
                            <td><?php echo $resultado_mensajes['nombre_contacto'] ?></td>
                            <td><?php echo $resultado_mensajes['correo_contacto'] ?></td>
                            <td><?php echo $resultado_mensajes['mensaje_contacto'] ?></td>
                            <td>
                                <form action="../../models/crud_correos.php?contacto_id=<?php echo $resultado_mensajes['contacto_id']?>&id_usuario=<?php echo $id?>" method="POST">
                                    <button name="eliminar_buzon" type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <div class="col-md-4">
            <center>
                <h3>Envio de Mensajes</h3>
            </center>
            <form action="../../models/crud_mensajes.php?id_usuario=<?php echo $id?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Para</label>

                    <select name="nombre" id="" class="form-control">
                        <?php
                        $buscar_usuarios = "SELECT id_usuario,nickname_usuario FROM usuarios WHERE tipo_usuario = 'cliente' group by nickname_usuario";
                        $ejecutar_queryBusqueda = mysqli_query($conexion, $buscar_usuarios) or die(mysqli_error($conexion));
                        while ($resultado_busqueda = mysqli_fetch_array($ejecutar_queryBusqueda)) {
                        ?>
                            <option value="<?php echo $resultado_busqueda['id_usuario'] ?>">
                                <?php echo $resultado_busqueda['nickname_usuario'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" name="mensaje" id="mensaje" rows="3"></textarea>
                </div>
                <button type="submit" name="enviar_mensaje" class="btn btn-primary">Enviar</button>
        </div>
        <div class="col-md-2"></div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#notifications").on("click", function() {
                $.ajax({
                    url: "../../models/readNotifications.php",
                    success: function(res) {
                        console.log(res);
                    }
                });
            });
        });
    </script>
</body>

</html>