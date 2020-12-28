<?php
    require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$equipos = DAO::equipoObtenerTodos();
?>

<html>
    <head>
        <title>Equipos Listado</title>
    </head>
    <body> 
        <h1>Listado de Equipos</h1>
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
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getNombre()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getPuntos()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getPartidosJugados()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getVictorias()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getEmpates()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getDerrotas()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getGolesFavor()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getGolesContra()?> </a></td>
                    <td><a href='EquipoFicha.php?id=<?=$equipo->getId()?>'>    <?=$equipo->getDiferenciaGoles()?> </a></td>
                    <td><a href='EquipoEliminar.php?id=<?=$equipo->getId()?>'> (X)                       </a></td>
                </tr>
            <?php } ?>

        </table><br>
        <a href='EquipoFicha.php?id=-1'>Crear entrada</a>
    </body>
</html>