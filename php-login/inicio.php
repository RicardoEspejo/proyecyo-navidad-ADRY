<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";

// UNA VEZ INICIES SESION TE REDIRGIRÁ A ESTE PHP

// LA MISMA FUNCION COMENTADA EN EL INDEX
if (isset($_SESSION["id_Usuario"])) {
    $id = $_SESSION["id_Usuario"];
    $resultado = DAO::ObtenerSesionIniciada($id);

    $usuario = null;
    if (count($resultado) > 0) {
        $usuario = $resultado;
    }
}

//SI NO TIENES LOS PERMISOS DE ADMINISTRADOR , NO TE DEJA HACER EL SORTEO
if(isset($_REQUEST["noPermisos"])) {
    echo "No tienes permisos para realizar un sorteo.<br>";
}
//SI NO EXITEN ÁRBITROS Y/O EQUIPOS NO SE PUEDE REALIZAR EL SORTEO
if(isset($_REQUEST["noDatos"])) {
    echo "No se puede realizar el sorteo si no hay árbitros y equipos registrados.<br>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL inicio</title>
    <?php if(isset($_SESSION["tema"])){?>
    <?php if($_SESSION["tema"] == "claro"){ ?>
        <link rel='stylesheet' href='../disenio/modoClaro.css'>
    <?php }else{ ?>
        <link rel='stylesheet' href='../disenio/modoOscuro.css'>
    <?php } }else{?>
        <link rel='stylesheet' href='../disenio/modoClaro.css'>
    <?php } ?>
</head>

<body>
    <header>
        <form action='../modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
        <input type="hidden" name="nombre" value="php-login/inicio.php">
        <select name="modo" onChange="formulario.submit();">
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>
         <a href="cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>  
    </header>
    <!-- ESTE PHP TE CONECTA CON EL RETSO DE PHP´S DESDE EL MENU PRINCIPAL -->
    <h1>ADRY-GOL</h1>
    <h2>MENÚ PRINCIPAL</h2>
    <!-- SALUDAMOS AL USUARIO  -->
    <h3>Bienvenido: <strong><?= $usuario[1] ?></strong></h3>
    <div id="menu">
        <ul>
            <li><a href="../php-login">Inicio</a></li>
            <li><a href="../equipoListado.php">Equipos</a></li>
            <li><a href="../arbitroListado.php">Árbitros</a></li>
            <li><a href="../partidoListado.php">Partidos</a></li>
            <li><a href="../clasificacion.php">Clasificación</a></li>
            <li><a href="../sorteo.php">Sorteo</a></li>
        </ul>
    </div>

    <img src="../disenio/brazil.jfif" width="380" height="200">
</body>

</html>