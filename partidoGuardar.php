<?php
	require_once "comunicaBD/dao.php";

    $id_Partido = $_REQUEST["id_Partido"];
    $id_Equipo_Local = $_REQUEST["id_Equipo_Local"];
    $id_Equipo_Visitante = $_REQUEST["id_Equipo_Visitante"];
    $fecha = $_REQUEST["fecha"];
    $id_Arbitro = $_REQUEST["id_Arbitro"];
    $gol_Local = $_REQUEST["gol_Local"];
    $ganador = $_REQUEST["ganador"];

    $partido= DAO::partidoFicha($id);
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
        <h2>Partidos > Guardar</h2>
        <?php
        if($id != -1) {
            $modificacionCorrecta= DAO::partidoActualizarPorID($id_Partido, $id_Equipo_Local, 
            $id_Equipo_Visitante, $fecha, $id_Arbitro, $gol_Local, $gol_Visitante, $ganador);
            if($modificacionCorrecta) { ?>
                <h3>Se ha modificado correctamente el partido.</h3>
            <?php } else ?>
            <h3>Error en la modificación.</h3>
        <?php }else {
            $creacionCorrecta= DAO::partidoCrear($id_Equipo_Local, 
            $id_Equipo_Visitante, $fecha, $id_Arbitro);
            if($creacionCorrecta) {?>
                <h3>Se ha creado correctamente el partido.</h3>
            <?php } else ?>
                <h3>Error en la creación.</h3>
        <?php } ?>
        <a href='partidoListado.php'>Ir al listado de partidos</a></br>
    </body>
</html>