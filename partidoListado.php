<?php
require_once "comunicaBD/varios.php";
require_once "comunicaBD/dao.php";

$partidos = DAO::partidoObtenerTodos();

if (isset($_REQUEST["buscar"])) {
    $buscar = strtolower($_REQUEST["buscar"]);
    $buscador = true;
    $buscarPartidos = DAO::buscarPartidos($buscar);
} else {
    $buscador = false;
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL</title>
    <meta name="description" content="-">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(isset($_SESSION["tema"])){?>
    <?php if($_SESSION["tema"] == "claro"){ ?>
        <link rel='stylesheet' href='disenio/modoClaro.css'>
    <?php }else{ ?>
        <link rel='stylesheet' href='disenio/modoOscuro.css'>
    <?php } }else{?>
        <link rel='stylesheet' href='disenio/modoClaro.css'>
    <?php } ?>
</head>

<body>
<header>
        <a href='/proyectoClase/proyecyo-navidad-ADRY/php-login/inicio.php' class="menuPrincipal">Menu Principal</a>
    <form action='modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
        <input type="hidden" name="nombre" value="partidoListado.php">
        <select name="modo" onChange="formulario.submit();">
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>  
      <a href="../proyecyo-navidad-ADRY/php-login/cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>
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
                        <td><a href='PartidoFicha.php?id_Partido=<?= $partido->getId() ?>'><?= $partido->getId() ?></a></td>
                        <td><?= $nombreLocal = DAO::equipoObtenerNombre($partido->getEquipoLocal()); ?></td>
                        <td><?= $nombreVisitante = DAO::equipoObtenerNombre($partido->getEquipoVisitante()); ?></td>
                        <td><?= $partido->getFecha() ?></td>
                        <td><?= $nombreArbitro = DAO::arbitroObtenerNombre($partido->getArbitro()); ?></td>
                        <td><?= $partido->getGolLocal() ?> </td>
                        <td><?= $partido->getGolVisitante() ?> </td>
                        <td><?= $partido->getGanador() ?> </td>
                        <td><a href='PartidoEliminar.php?id_Partido=<?= $partido->getId() ?>'> (<img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <p>
                <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                <?php header("refresh:5;url=partidoListado.php") ?>
                </p>
            <?php } ?>
        <?php } else { ?>
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
                        <td><a href='PartidoFicha.php?id_Partido=<?= $partido->getId() ?>'><?= $partido->getId() ?></a></td>
                        <td><?= $nombreLocal = DAO::equipoObtenerNombre($partido->getEquipoLocal()); ?></td>
                        <td><?= $nombreVisitante = DAO::equipoObtenerNombre($partido->getEquipoVisitante()); ?></td>
                        <td><?= $partido->getFecha() ?></td>
                        <td><?= $nombreArbitro = DAO::arbitroObtenerNombre($partido->getArbitro()); ?></td>
                        <td><?= $partido->getGolLocal() ?> </td>
                        <td><?= $partido->getGolVisitante() ?> </td>
                        <td><?= $partido->getGanador() ?> </td>
                        <td><a href='PartidoEliminar.php?id_Partido=<?= $partido->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                    </tr>
                <?php } ?>
            <?php } ?>

            </table><br>
                </div>
            <a href='PartidoFicha.php?id_Partido=-1'>Crear entrada</a>
           
</body>

</html>