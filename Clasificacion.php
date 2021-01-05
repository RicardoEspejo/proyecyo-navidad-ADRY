<?php
    require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $equipos = DAO::ClasificacionObtener();

    if(isset($_REQUEST["buscar"])){
        $buscar=strtolower($_REQUEST["buscar"]);
        $buscador=true;
        $buscarEquipo=DAO::buscarEquipos($buscar);
    }else{
        $buscador=false;
    }  

?>

<html>
    <head>
        <title>Clasificacion</title>
    </head>
    <body> 
    <header>
        <a href='/proyectoClase/proyecyo-navidad-ADRY/php-login/inicio.php'>Fútbol de Barrio</a>
    </header>
    <h1>CLASIFICACIÓN</h1>
    <form action='' method='post'>
            <?php if($buscador == true){  ?>
                <input type="search" placeholder="Buscar" name="buscar" value="<?= $buscar  ?>">
                <a href="EquipoListado.php"><img src="disenio/delete.png" alt="volver al listado" height="22px" class="deleteArbitro "></a>
            <?php }else{ ?>
                <input type="search" placeholder="Buscar" name="buscar">
            <?php } ?>
                <input type="submit" value="Buscar">
        </form>
        <?php if($buscador == true) { ?>
            <?php if(count($buscarEquipo) >=1) { ?>
                <p>
                <h4>Resultados de la busqueda: <?= count($buscarEquipo)?></h4>
            </p>
                <table border='1'>
                    <tr>
                     <th>Nombre</th>
                    <th>Puntos</th>
                    <th>Partidos Jugados</th>
                    <th>Victorias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                    <th>Goles A Favor</th>
                    <th>Goles En Contra</th>
                    <th>Diferencia De Goles</th>
                     </tr>
                     <?php foreach ($buscarEquipo as $equipo) { ?>
                        <tr>
                    <td><a href='EquipoFicha.php?id_Equipo=<?=$equipo->getId()?>'>    <?=$equipo->getNombre()?> </a></td>
                    <td>    <?=$equipo->getPuntos()?> </td>
                    <td>    <?=$equipo->getPartidosJugados()?> </td>
                    <td>    <?=$equipo->getVictorias()?> </td>
                    <td>    <?=$equipo->getEmpates()?> </td>
                    <td>    <?=$equipo->getDerrotas()?> </td>
                    <td>    <?=$equipo->getGolesFavor()?> </td>
                    <td>    <?=$equipo->getGolesContra()?> </td>
                    <td>    <?=$equipo->getDiferenciaGoles()?> </td>
                    <td><a href='EquipoEliminar.php?id_Equipo=<?=$equipo->getId()?>'> (X)  </a></td>
                </tr>
                <?php } ?>


            <?php } else{ ?>
                <p>
                <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                <?php header("refresh:5;url=EquipoListado.php") ?>
            </p>
            <?php } ?>
        <?php }else{ ?>
            <table border='1'>
                    <tr>
                     <th>Nombre</th>
                    <th>Puntos</th>
                    <th>Partidos Jugados</th>
                    <th>Victorias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                    <th>Goles A Favor</th>
                    <th>Goles En Contra</th>
                    <th>Diferencia De Goles</th>
                     </tr>
            <?php foreach ($equipos as $equipo) { ?>
                <tr>
                    <td><a href='EquipoFicha.php?id_Equipo=<?=$equipo->getId()?>'>    <?=$equipo->getNombre()?> </a></td>
                    <td>    <?=$equipo->getPuntos()?> </td>
                    <td>    <?=$equipo->getPartidosJugados()?> </td>
                    <td>    <?=$equipo->getVictorias()?> </td>
                    <td>    <?=$equipo->getEmpates()?> </td>
                    <td>    <?=$equipo->getDerrotas()?> </td>
                    <td>    <?=$equipo->getGolesFavor()?> </td>
                    <td>    <?=$equipo->getGolesContra()?> </td>
                    <td>    <?=$equipo->getDiferenciaGoles()?> </td>
                    <td><a href='EquipoEliminar.php?id_Equipo=<?=$equipo->getId()?>'> (X)  </a></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </table><br>
        <a href='EquipoFicha.php?id_Equipo=-1'>Crear entrada</a>
    </body>
</html>