<?php
    require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $partidos = DAO::partidoObtenerTodos();
    
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ADRY-GOL</title>
        <meta name="description" content="-">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="disenio/ADRY.css">
    </head>
    <body>
        <h1>ADRY-GOL</h1>
        <h2>Partidos > Listado</h2>
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
                    <td><?=$nombreLocal = DAO::equipoObtenerNombre($partido->getEquipoLocal());?></td>
                    <td><?=$nombreVisitante = DAO::equipoObtenerNombre($partido->getEquipoVisitante());?></td>
                    <td><?=$partido->getFecha()?></td>
                    <td><?=$nombreArbitro = DAO::arbitroObtenerNombre($partido->getArbitro());?></td>
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