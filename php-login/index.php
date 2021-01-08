<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";

if (isset($_SESSION["id_Usuario"])) {
    $id = $_SESSION["id_Usuario"];
    $resultado = DAO::ObtenerSesionIniciada($id);
    $usuario = null;
    if (count($resultado) > 0) {
        $usuario = $resultado;
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>

<body>
    <header>
        <a href="../php-login">ADRYGOL</a>
    </header>
    <?php if (!empty($usuario)) : ?>
        <h1>Liga de fútbol de Barrio</h1>
        <h3>Bienvenido: <strong><?= $usuario[1] ?></strong></h3>
        <h3>Tienes una sesión iniciada.</h3>
        <h3>¿Desea continuar? <a href="inicio.php">Continuar</a> </h3>
        <h3>¿Desea cerrar sesión? <a href="cerrarSesion.php">Cerrar Sesion</a> </h3>

    <?php else : ?>
        <h1>Bienvenido a la Liga ADRYGOL</h1>
        <h3>
            Elija una opción para acceder
            <a href="inicioSesion.php">Iniciar Sesión</a>
            O
            <a href="registro.php">Registrarse</a>
        </h3>
    <?php endif; ?>
</body>

</html>