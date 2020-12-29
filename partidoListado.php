<?php
    require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $partidos = DAO::partidoObtenerTodos();
    
    if(isset($_REQUEST["creacionCorrecta"]))
        echo "<p>Partido creado correctamente</p>";
    else if(isset($_REQUEST["creacionErronea"]))
        echo "<p>Error al crear</p>";

    if(isset($_REQUEST["eliminacionCorrecta"]))
        echo "<p>Partido eliminado correctamente</p>";
    else if(isset($_REQUEST["eliminacionErronea"]))
        echo "<p>Error al eliminar</p>";
?>
<html>
    <head>
        <title>Partidos Listado</title>
    </head>
    <body> 
        <h1>Listado de Partidos</h1>
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
                    <td><a href='PartidoFicha.php?id_Partido=<?=$partido->getId()?>'><?=$partido->getId()?></a></td>
                    <td><?=$partido->getEquipoLocal()?></td>
                    <td><?=$partido->getEquipoVisitante()?> </td>
                    <td></td><?=$partido->getFecha()?> </td>
                    <td><?=$partido->getArbitro()?> </td>
                    <td><?=$partido->getGolLocal()?> </td>
                    <td><?=$partido->getGolVisitante()?> </td>
                    <td><?=$partido->getGanador()?> </td>
                    <td><a href='PartidoEliminar.php?id_Partido=<?=$partido->getId()?>'> (X)</a></td>
                </tr>
            <?php } ?>
        </table><br>
        <a href='PartidoFicha.php?id_Partido=-1'>Crear entrada</a>
    </body>
</html>