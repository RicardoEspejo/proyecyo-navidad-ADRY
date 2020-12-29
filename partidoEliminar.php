<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $id = (int)$_REQUEST["id_Partido"];
    $correcto = DAO::partidoEliminarPorID($id);
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
        <h2>Partidos > Eliminar</h2>
        <?php if ($correcto) { ?>
            <h3>Eliminación realizada con éxito.</h3>
        <?php } else { ?>
            <h3>Error en la eliminación.</h3>
        <?php } ?>
        <a href='partidoListado.php'>Ir al listado de partidos.</a></br>
    </body>
</html>