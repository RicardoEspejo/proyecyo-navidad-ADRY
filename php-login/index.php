<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";


//ESTE PHP ES EL PRIMER PHP CON EL QUE TIENE EL USAURIO CONTACTO.

//AQUI COMPROBAMOSSI HAY UNA SESION INICIADA.
if (isset($_SESSION["id_Usuario"])) {
    //EN EL CASO DE QUE ESTE INICIADA, RECOGEMOS EL ID Y OBTENEMOS AL USAURIO CON EL METODO QUE HAY ACONTINUACIÓN.
    $id = $_SESSION["id_Usuario"];
    $resultado = DAO::ObtenerSesionIniciada($id);
    $usuario = null;
    //EN EL CASO DE QUE OBTENGAMOS UN RESULTADO, LO ALMACENAMOS EN USAURIO
    if (count($resultado) > 0) {
        $usuario = $resultado;
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL index</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (isset($_SESSION["tema"])) { ?>
        <?php if ($_SESSION["tema"] == "claro") { ?>
            <link rel='stylesheet' href='../disenio/modoClaro.css'>
        <?php } else { ?>
            <link rel='stylesheet' href='../disenio/modoOscuro.css'>
        <?php }
    } else { ?>
        <link rel='stylesheet' href='../disenio/modoClaro.css'>
    <?php } ?>
</head>

<body>
    <header>
        <form action='../modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
            <input type="hidden" name="nombre" value="php-login/index.php">
            <select name="modo" onChange="formulario.submit();">
                <option value="claro" <?php if (isset($_SESSION["tema"])) {
                                            if ($_SESSION["tema"] == "claro") { ?> selected <?php }
                                                                                                                } ?>>Tema Claro</option>
                <option value="oscuro" <?php if (isset($_SESSION["tema"])) {
                                            if ($_SESSION["tema"] == "oscuro") { ?> selected <?php }
                                                                                                                } ?>>Tema Oscuro</option>
            </select>
        </form>
    </header>
    <!-- EN EL CASO DE QUE LA VARIABLE USAURIO NO ESTE VACÍA, SIGNIFICA QUE TENEMOS UNA SESION INICIADA, ASÍ QUE VA A DEVOLVER ESTO  -->
    <?php if (!empty($usuario)) : ?>
        <h1>ADRY-GOL</h1>
        <h3>Bienvenido: <strong><?= $usuario[1] ?></strong></h3>
        <h3>Tienes una sesión iniciada.</h3>
        <!-- LE DAMOS LA OPCION DE CONTINUAR O DE CERRAR LA SESION -->
        <h3>¿Desea continuar? <a href="inicio.php">Continuar</a> </h3>
        <h3>¿Desea cerrar sesión? <a href="cerrarSesion.php">Cerrar Sesion</a> </h3>

    <?php else : ?>
        <!-- EN EL CASO DE QUE NO HAYA SESION LE DAMOS LA OPCION DE REGISTRARSE O INICIAR DE SESION -->
        <h1>Bienvenido a ADRY-GOL</h1>
        <h3>
            Elija una opción para acceder: </br></br>
            <a href="inicioSesion.php">Iniciar Sesión</a>
            O
            <a href="registro.php">Registrarse</a>
        </h3>
    <?php endif; ?>
</body>

</html>