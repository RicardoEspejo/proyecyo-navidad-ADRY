<?php
require_once "comunicaBD/varios.php";
require_once "comunicaBD/dao.php";

$partidos = DAO::partidoObtenerTodos();

//Conexión con el buscador
if (isset($_REQUEST["buscar"])) {
    $buscar = strtolower($_REQUEST["buscar"]);
    $buscador = true;
    $buscarPartidos = DAO::buscarPartidos($buscar);
} else {
    $buscador = false;
}

//Notificaciones de creación y eliminación
if (isset($_REQUEST["creacionCorrecta"]))
    echo "<p>Partido creado correctamente</p>";
else if (isset($_REQUEST["creacionErronea"]))
    echo "<p>Error al crear</p>";

if (isset($_REQUEST["eliminacionCorrecta"]))
    echo "<p>Partido eliminado correctamente</p>";
else if (isset($_REQUEST["eliminacionErronea"]))
    echo "<p>Error al eliminar</p>"; 

?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL partido listado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php //Determina el tema seleccionado
        if (isset($_SESSION["tema"])) { ?>
        <?php if ($_SESSION["tema"] == "claro") { ?>
            <link rel='stylesheet' href='disenio/modoClaro.css'>
        <?php } else { ?>
            <link rel='stylesheet' href='disenio/modoOscuro.css'>
        <?php }
    } else { ?>
        <link rel='stylesheet' href='disenio/modoClaro.css'>
    <?php } ?>
</head>

<body>
    <header> <!-- Link menú principal, selección de tema y link cerrar sesión -->
        <a href='php-login/inicio.php' class="menuPrincipal">Menu Principal</a>
        <form action='modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
            <input type="hidden" name="nombre" value="partidoListado.php">
            <select name="modo" onChange="formulario.submit();">
                <option value="claro" <?php if (isset($_SESSION["tema"])) {
                    if ($_SESSION["tema"] == "claro") { ?> selected <?php }
                } ?>>Tema Claro</option>
                <option value="oscuro" <?php if (isset($_SESSION["tema"])) {
                    if ($_SESSION["tema"] == "oscuro") { ?> selected <?php }
                } ?>>Tema Oscuro</option>
            </select>
        </form>
        <a href="php-login/cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>
    </header>
    <div class="contenedor">
        <h1>ADRY-GOL</h1>
        <div class="contenedor2">
            <h2>Partidos > Listado</h2>
            <form action='' method='post' class="buscador2">
                <?php if ($buscador == true) {  ?>
                    <input type="search" placeholder="Buscar" name="buscar" value="<?= $buscar  ?>" class="buscador">
                    <a href="partidoListado.php"><img src="disenio/delete.png" alt="volver al listado" height="22px" class="deleteArbitro "></a>
                <?php } else { ?>
                    <input type="search" placeholder="Buscar" name="buscar" class="buscador">
                <?php } ?>
                <input type="submit" value="Buscar">
            </form>
        </div> 
        <!-- BUSCADOR -->
        <?php if ($buscador == true) { ?>
            <?php if (count($buscarPartidos) >= 1) { ?>
                <p>
                <h4>Resultados de la busqueda: <?= count($buscarPartidos) ?></h4>
                </p>
                <table border='1'>
                    <tr>
                        <th>Número Partido</th>
                        <th>Equipo Local</th>
                        <th>Equipo Visitante</th>
                        <th>Fecha</th>
                        <th>Árbitro</th>
                        <th>Goles Local</th>
                        <th>Goles Visitante</th>
                        <th>Ganador</th>
                    </tr>
                    <?php foreach ($buscarPartidos as $partido) { ?>
                        <tr>
                        <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                                <td><a href='PartidoFicha.php?id_Partido=<?= $partido->getId() ?>'><?= $partido->getId() ?></a></td>
                            <?php } else { ?>
                                <td><?= $partido->getId() ?></td>
                            <?php } ?>
                            <td><?= $nombreLocal = DAO::equipoObtenerNombre($partido->getEquipoLocal()); ?></td>
                            <td><?= $nombreVisitante = DAO::equipoObtenerNombre($partido->getEquipoVisitante()); ?></td>
                            <td><?= $partido->getFecha() ?></td>
                            <td><?= $nombreArbitro = DAO::arbitroObtenerNombre($partido->getArbitro()); ?></td>
                            <td><?= $partido->getGolLocal() ?> </td>
                            <td><?= $partido->getGolVisitante() ?> </td>
                            <?php //MUESTRA EL NOMBRE DEL GANADOR
                                $tipoGanador = $partido->getGanador();
                                if($tipoGanador == 1)?>
                                    <td><?= $nombreLocal = DAO::equipoObtenerNombre($partido->getEquipoLocal());?></td>?><?php
                                if($tipoGanador == 0) ?><td>EMPATE</td><?php
                                if($tipoGanador == 2)?>
                                    <td><?= $nombreVisitante = DAO::equipoObtenerNombre($partido->getEquipoVisitante()); ?></td>
                            <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                                <><a href='PartidoEliminar.php?id_Partido=<?= $partido->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <p>
                    <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                    <?php header("refresh:5;url=partidoListado.php") ?>
                    </p>
                <?php } ?>
            <?php } else { ?>
            <!-- TABLA LISTADO -->
                <table border='1'>
                    <tr>
                        <th>Número Partido</th>
                        <th>Equipo Local</th>
                        <th>Equipo Visitante</th>
                        <th>Fecha</th>
                        <th>Árbitro</th>
                        <th>Goles Local</th>
                        <th>Goles Visitante</th>
                        <th>Ganador</th>
                    </tr>
                    <?php foreach ($partidos as $partido) { ?>
                        <tr>
                            <!-- SI ES USUARIO ÁRBITRO PERMITE EL ACCESO A LA FICHA -->
                            <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                                <td><a href='PartidoFicha.php?id_Partido=<?= $partido->getId() ?>'><?= $partido->getId() ?></a></td>
                            <?php } else { ?>
                                <td><?= $partido->getId() ?></td>
                            <?php } ?>
                            <!-- MUESTRA EL NOMBRE DEL EQUIPO EN LUGAR DEL ID -->
                            <td><?= $nombreLocal = DAO::equipoObtenerNombre($partido->getEquipoLocal()); ?></td>
                            <td><?= $nombreVisitante = DAO::equipoObtenerNombre($partido->getEquipoVisitante()); ?></td>
                            <td><?= $partido->getFecha() ?></td>
                            <td><?= $nombreArbitro = DAO::arbitroObtenerNombre($partido->getArbitro()); ?></td>
                            <td><?= $partido->getGolLocal() ?> </td>
                            <td><?= $partido->getGolVisitante() ?> </td>
                            <td><?= $partido->getGanador() ?> </td>
                            <?php //SI ES USUARIO ÁRBITRO PERMITE LA ELIMINACIÓN
                                if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                                <td><a href='PartidoEliminar.php?id_Partido=<?= $partido->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } ?>

                </table><br>
    </div>
    <?php //SI ES USUARIO ÁRBITRO PERMITE CREAR NUEVO PARTIDO
        if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
        <a href='PartidoFicha.php?id_Partido=-1'>Crear entrada</a>
    <?php } ?>
</body>

</html>