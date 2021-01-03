<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$id = (int)$_REQUEST["id_Partido"];
    $partido= DAO::partidoFicha($id);
	$nuevaEntrada= $partido[0];
	$rsEquipos= DAO::partidoSelectEquipos();
	$rsArbitros= DAO::partidoSelectArbitros();
	$localId = $partido[1];
	$VisitanteId = $partido[2];
	$arbitroId = $partido[4];
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
			<select name='equipoLocalId'>
				<?php foreach ($rsEquipos as $filaEquipo) {
					$id_Equipo = (int) $filaEquipo["id_Equipo"];
					$nombre = $filaEquipo["nombre"];
					if ($id_Equipo == $localId) $seleccion = "selected='true'";
					else $seleccion = "";
					echo "<option value='$id_Equipo' $seleccion>$nombre</option>";
				}?>
			</select><br/>
			<label>Equipo visitante: </label>
			<select name='equipoVisitanteId'>
				<?php foreach ($rsEquipos as $filaEquipo) {
					$id_Equipo = (int) $filaEquipo["id_Equipo"];
					$nombre = $filaEquipo["nombre"];
					if ($id_Equipo == $localId) $seleccion = "selected='true'";
					else $seleccion = "";
					echo "<option value='$id_Equipo' $seleccion>$nombre</option>";
				}?>
			</select><br/>
			<label>Fecha: </label>
			<input type='text' name='fecha' value='<?=$partido[3]?>'><br/>
			<label>Árbitro:</label>
			<select name='arbitroId'>
				<?php foreach ($rsArbitros as $filaArbitro) {
					$id_Arbitro = (int) $filaArbitro["id_Arbitro"];
					$nombre = $filaArbitro["nombre"]." ". $filaArbitro["apellidos"];
					if ($id_Arbitro == $ArbitroId) $seleccion = "selected='true'";
					else $seleccion = "";
					echo "<option value='$id_Arbitro' $seleccion>$nombre</option>";
				}?>
			</select><br/>
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