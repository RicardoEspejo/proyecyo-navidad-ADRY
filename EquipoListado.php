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
                    <td><a href='EquipoFicha.php?id_Equipo=<?=$equipo->getId()?>'>    <?=$equipo->getNombre()?> </a></td>
                    <td>    <?=$equipo->getPuntos()?> </td>
                    <td>    <?=$equipo->getPartidosJugados()?> </td>
                    <td>    <?=$equipo->getVictorias()?> </td>
                    <td>    <?=$equipo->getEmpates()?> </td>
                    <td>    <?=$equipo->getDerrotas()?> </td>
                    <td>    <?=$equipo->getGolesFavor()?> </td>
                    <td>    <?=$equipo->getGolesContra()?> </td>
                    <td>    <?=$equipo->getDiferenciaGoles()?> </td>
                    <td><a href='EquipoEliminar.php?id=<?=$equipo->getId()?>'> (X)  </a></td>
                </tr>
            <?php } ?>

        </table><br>
        <a href='EquipoFicha.php?id=-1'>Crear entrada</a>
    </body>
</html>