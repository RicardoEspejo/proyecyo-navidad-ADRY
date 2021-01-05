<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";

session_start();

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>
    <header>
        <a href="../php-login">ADRYGOL</a>
    </header>
    <div id="menu">
        <ul>
            <li><a href="../php-login">Inicio</a></li>
            <li><a href="../EquipoListado.php">Equipos</a></li>
            <li><a href="../ArbitroListado.php">Árbitros</a></li>
            <li><a href="../partidoListado.php">Partidos</a></li>
            <li><a href="../Clasificacion.php">Clasificación</a></li>
            <li><a href="cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>

    <h1>Liga ADRYGOL</h1>
    <h3>Bienvenido: <strong><?= $usuario[1] ?></strong></h3>
    <h3>Elija una opción del Menú</h3>

    <img src="../documentos/brazil.jfif">
</body>

</html>