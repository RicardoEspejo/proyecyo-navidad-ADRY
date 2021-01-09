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

    <h1>ADRY-GOL</h1>
    <h2>MENÚ PRINCIPAL</h2>
    <h3>Bienvenido: <strong><?= $usuario[1] ?></strong></h3>
    <div id="menu">
        <ul>
            <li><a href="../php-login">Inicio</a></li>
            <li><a href="../EquipoListado.php">Equipos</a></li>
            <li><a href="../ArbitroListado.php">Árbitros</a></li>
            <li><a href="../partidoListado.php">Partidos</a></li>
            <li><a href="../Clasificacion.php">Clasificación</a></li>
            <li><a href="../sorteo.php">Sorteo</a></li>
        </ul>
    </div>

    <img src="../disenio/brazil.jfif" width="380" height="200">
</body>

</html>