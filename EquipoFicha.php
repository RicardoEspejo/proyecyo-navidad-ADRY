<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$id = (int)$_REQUEST["id_Equipo"];
    $equipo= DAO::equipoFicha($id);
    $nuevaEntrada= $equipo[0];

    if($equipo[10] != "") {
        echo "<img src='disenio/".$equipo[10]."' width='100' heigth='100'>";
    } else {
        echo "<img src='disenio/fotoEscudo.JPEG' width='100' heigth='100'>";
    }

?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada == true) { ?>
	<h1>Nueva ficha de Equipo</h1>
<?php } else { ?>
	<h1>Ficha de Equipo</h1>
<?php } ?>

<form method='post' action='EquipoGuardar.php'>

<input type='hidden' name='id' value='<?=$id?>' />

    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' value='<?=$equipo[1]?>' />
    <br/>
    <label for='nombre'>Puntos</label>
	<input type='text' name='pntos' value='<?=$equipo[2]?>' />
    <br/>
    <label for='nombre'>Partidos Jugados</label>
	<input type='text' name='partidosJugados' value='<?=$equipo[3]?>' readonly/>
    <br/>
    <label for='nombre'>Victorias</label>
	<input type='text' name='victorias' value='<?=$equipo[4]?>' readonly/>
    <br/>
    <label for='nombre'>Empates</label>
	<input type='text' name='empates' value='<?=$equipo[5]?>' readonly/>
    <br/>
    <label for='nombre'>Derrotas</label>
	<input type='text' name='derrotas' value='<?=$equipo[6]?>' readonly/>
    <br/>
    <label for='nombre'>Goles a favor</label>
	<input type='text' name='golesFavor' value='<?=$equipo[7]?>' readonly/>
    <br/>
    <label for='nombre'>Goles en contra</label>
	<input type='text' name='golesContra' value='<?=$equipo[8]?>' readonly/>
    <br/>
    <label for='nombre'>Diferencia de goles</label>
	<input type='text' name='diferenciaGoles' value='<?=$equipo[9]?>' readonly/>
    <br/>
    <label>Escudo</label>
    <input type="file" name="escudo" id="escudo"><br>

    <br/>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear equipo' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<?php if (!$nuevaEntrada) { ?>
    <a href='EquipoEliminar.php?id=<?=$id?>'>Eliminar equipo</a>
<?php } ?>

<br />
<br />

<a href='EquipoListado.php'>Volver al listado de equipos.</a>

</body>

</html>