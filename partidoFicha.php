<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$id = (int)$_REQUEST["id_Partido"];
    $partido= DAO::partidoFicha($id);
	$nuevaEntrada= $partido[0];
	
	if(isset($_REQUEST["modificacionCorrecta"]))
        echo "<p>Partido actualizado correctamente</p>";
    else if(isset($_REQUEST["modificacionErronea"]))
        echo "<p>Error al actualizar</p>";
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
        <h2>Partidos > Ficha</h2>
		<form method='post' action='PartidoGuardar.php' enctype="multipart/form-data">
			<input type='hidden' name='id_Partido' value='<?=$id?>'>
			<label>Equipo local: </label>
			<input type='text' name='id_Equipo_Local' value='<?=$partido[1]?>' readonly><br/>
			<label>Equipo visitante: </label>
			<input type='text' name='id_Equipo_Visitante' value='<?=$partido[2]?>' readonly><br/>
			<label>Fecha: </label>
			<input type='text' name='fecha' value='<?=$partido[3]?>'><br/>
			<label>Árbitro:</label>
			<input type='text' name='id_Arbitro' value='<?=$partido[4]?>' readonly><br/>
			<label>Goles Local</label>
			<input type='number' name='gol_Local' value='<?=$partido[5]?>'><br/>
			<label>Goles Visitante</label>
			<input type='number' name='gol_Visitante' value='<?=$partido[6]?>'><br/>
			<label>Ganador</label>
			<input type='number' name='ganador' value='<?=$partido[7]?>'><br/>
			
			<?php if ($nuevaEntrada) { ?>
				<input type='submit' name='crear' value='Crear partido' />
			<?php } else { ?>
				<input type='submit' name='guardar' value='Guardar cambios' />
			<?php } ?>
		</form>

		<?php if (!$nuevaEntrada) { ?>
			<a href='partidoEliminar.php?id_Partido=<?=$id?>'>Eliminar partido</a>
		<?php } ?>
		<br/>
		<a href='partidoListado.php'>Volver al listado de partidos.</a>
	</body>
</html>