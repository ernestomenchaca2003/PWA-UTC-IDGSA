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
$membresia = $resultado_usuario['membresia'];

$notificacion_mensaje = "SELECT * FROM mensajes WHERE mensaje_to = $id AND estado = 0  ORDER BY mensaje_id DESC  limit 5";
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
    <title>Clientes</title>
</head>

<body style="overflow-x: hidden;">
    <?php
    switch ($membresia) {
        case 'basica': {
    ?>
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a class="navbar-brand" href="#">Cliente</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <a href="" id="notifications"><img src="../../public/icons/notification.png" alt="" style="margin-right: -15px;">
                                <span class="count" style="background-color: red; color: white;border-radius: 5px; position:relative"><?php echo mysqli_num_rows($ejecutar_queryNotificacion) ?></span>
                            </a>
                            <li class="nav-item">
                                <a class="nav-link" href="../../models/cerrar_sesion.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="row">
                    <div class="col-md-5">
                        <div class="container">
                            <center>
                                <h3 style="color:mediumseagreen">Información de Perfil</h3>
                            </center>

                            <form action="../../models/crud_usuarios.php?id_usuario=<?php echo $id ?>" class="form-group" method="POST">
                                <label for="">Nombre:</label>
                                <input type="text" name="nombre_usuario" value="<?php echo $resultado_usuario['nombre_usuario'] ?>" class="form-control">
                                <label for="">Correo</label>
                                <input type="text" name="correo_usuario" value="<?php echo $resultado_usuario['correo_usuario'] ?>" class="form-control">
                                <label for="">Contraseña</label>
                                <input type="text" name="password_usuario" value="<?php echo $resultado_usuario['password_usuario'] ?>" class="form-control"><br>
                                <button class="btn float-right" style="background-color:mediumseagreen; color: white" type="submit" name="actualizar_usuario">Actualizar</button><br><br>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-7">
                        <form action="../Clientes/?id_usuario=<?php echo $id ?>" method="POST">
                            <center>
                                <button type="submit" name="mensajes" class="btn btn-outline-primary">Mis mensajes</button>
                                <button type="submit" name="helpdesk" class="btn btn-outline-success">Help Desk</button>
                                <?php

                                if (mysqli_num_rows($ejecutar_queryNotificacion) > 0) {
                                    foreach ($ejecutar_queryNotificacion as $notificacion) {
                                ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $notificacion['mensaje_from'] ?> te ha enviado un mensaje
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                <?php
                                    }
                                }
                                ?>
                            </center>
                        </form>
                        <?php
                        if (isset($_POST['mensajes'])) {
                        ?>
                            <div class="container">
                                <h2>Mensajes</h2>

                                <table class="table table-dark">
                                    <thead>
                                        <tr>
                                            <th>De</th>
                                            <th>Mensaje</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $buscar_mensajes = "SELECT * FROM mensajes WHERE mensaje_to = $id order by mensaje_to desc limit 10";
                                        $ejecutar_queryBusqueda = mysqli_query($conexion, $buscar_mensajes) or die(mysqli_error($conexion));
                                        while ($resultado_mensajes = mysqli_fetch_array($ejecutar_queryBusqueda)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $resultado_mensajes['mensaje_from']; ?></td>
                                                <td><?php echo $resultado_mensajes['mensaje']; ?></td>
                                                <td>
                                                    <form action="../../models/crud_mensajes.php?id_mensaje=<?php echo $resultado_mensajes['mensaje_id'] ?>&id_usuario=<?php echo $id ?>" method="POST">
                                                        <button type="submit" class="btn btn-outline-danger" name="eliminar">DROP</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if (isset($_POST['helpdesk'])) {
                        ?>
                            <div class="container">
                                <h2>Help Desk no disponible en su cuenta actual</h2>
                                <br>
                                <button class="btn btn-success">Solicitar Premium</button>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }

            break;
        case 'premium': {
            ?>
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a class="navbar-brand" href="#">Cliente</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="../../models/cerrar_sesion.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="row">
                    <div class="col-md-5">
                        <div class="container">
                            <center>
                                <h3 style="color:mediumseagreen">Información de Perfil</h3>
                            </center>

                            <form action="../../models/crud_usuarios.php?id_usuario=<?php echo $id ?>" class="form-group" method="POST">
                                <label for="">Nombre:</label>
                                <input type="text" name="nombre_usuario" value="<?php echo $resultado_usuario['nombre_usuario'] ?>" class="form-control">
                                <label for="">Correo</label>
                                <input type="text" name="correo_usuario" value="<?php echo $resultado_usuario['correo_usuario'] ?>" class="form-control">
                                <label for="">Contraseña</label>
                                <input type="text" name="password_usuario" value="<?php echo $resultado_usuario['password_usuario'] ?>" class="form-control"><br>
                                <button class="btn float-right" style="background-color:mediumseagreen; color: white" type="submit" name="actualizar_usuario">Actualizar</button><br><br>
                            </form>

                        </div>
                    </div>

                    <div class="col-md-7">
                        <form action="../Clientes/?id_usuario=<?php echo $id ?>" method="POST">
                            <center>
                                <button type="submit" name="mensajes" class="btn btn-outline-primary">Mis mensajes</button>
                                <button type="submit" name="helpdesk" class="btn btn-outline-success">HelpDesk</button>
                            </center>
                        </form>
                        <?php
                        if (isset($_POST['mensajes'])) {
                        ?>
                            <div class="container">
                                <h2>Mensajes</h2>

                                <table class="table table-dark">
                                    <thead>
                                        <tr>
                                            <th>De</th>
                                            <th>Mensaje</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $buscar_mensajes = "SELECT * FROM mensajes WHERE mensaje_to = $id order by mensaje_to desc limit 10";
                                        $ejecutar_queryBusqueda = mysqli_query($conexion, $buscar_mensajes) or die(mysqli_error($conexion));
                                        while ($resultado_mensajes = mysqli_fetch_array($ejecutar_queryBusqueda)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $resultado_mensajes['mensaje_from']; ?></td>
                                                <td><?php echo $resultado_mensajes['mensaje']; ?></td>
                                                <td>
                                                    <form action="../../models/crud_mensajes.php?id_mensaje=<?php echo $resultado_mensajes['mensaje_id'] ?>&id_usuario=<?php echo $id ?>" method="POST">
                                                        <button type="submit" class="btn btn-outline-danger" name="eliminar">DROP</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if (isset($_POST['helpdesk'])) {
                        ?>
                            <center>
                                <h4>¿En que necesitas ayuda?</h4>
                            </center>
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="../../public/img/profile.png" alt=""> Mi Cuenta
                                </div>
                                <div class="col-md-3">
                                    <img src="../../public/img/notification.png" alt=""> Reportar un problema
                                </div>
                                <div class="col-md-3">
                                    <img src="../../public/img/service.png" alt=""> Solicitar un servicio
                                </div>
                                <div class="col-md-3">
                                    <img src="../../public/img/cancel.png" alt=""> Cancelar HelpDesk
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
    <?php
            }
            break;
    }
    ?>




    <footer style="background-color: black;">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <h5 style="color: white;">Siguenos en:</h5>
                <a target="_blank" href="https://www.facebook.com/"><img src="../../public/icons/facebook.png" alt="" width="30px" height="30px"></a>
                <a target="_blank" href="https://www.instagram.com/"><img src="../../public/icons/instagram.png" alt="" width="30px" height="30px"></a>
                <a target="_blank" href="https://www.twitter.com/"><img src="../../public/icons/twitter.png" alt="" width="30px" height="30px"></a>
                <a target="_blank" href="https://www.linkedincom/"><img src="../../public/icons/linkedin.png" alt="" width="30px" height="30px"></a>
            </div>
            <div class="col-md-4" style="color:white">
                <h5>Contactanos:</h5>
                <p>Tel: +52 844 535 3390</p>
                <p>Email: contacto@innova-software.mx</p>
            </div>
            <div class="col-md-2"></div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#notifications").on("click", function() {
                $.ajax({
                    url: "../../models/readNotificationsClientes.php",
                    success: function(res) {
                        console.log(res);
                    }
                });
            });
        });
    </script>
</body>

</html>