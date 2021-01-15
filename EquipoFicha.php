<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$id = (int)$_REQUEST["id_Equipo"];
    $equipo= DAO::EquipoFicha($id);
    $nuevaEntrada= $equipo[0];

    if(isset($_REQUEST["modificacionCorrecta"])) //Si hay modificación del equipo correcta lo indicamos
        echo "<p>Equipo actualizado correctamente</p>";
    else if(isset($_REQUEST["modificacionErronea"])) //Y si hay modificación erronea lo indicamos también
        echo "<p>Error al actualizar</p>";

?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL equipo ficha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(isset($_SESSION["tema"])){?>
    <?php if($_SESSION["tema"] == "claro"){ ?>
        <link rel='stylesheet' href='disenio/modoClaro.css'>
    <?php }else{ ?>
        <link rel='stylesheet' href='disenio/modoOscuro.css'>
    <?php } }else{?>
        <link rel='stylesheet' href='disenio/modoClaro.css'>
    <?php } ?>
</head>



<body>
<header>
    <a href='php-login/inicio.php' class="menuPrincipal">Menu Principal</a>     
    <form action='modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
        <input type="hidden" name="nombre" value="EquipoFicha.php?id_Equipo=<?= $id ?>">
        <select name="modo" onChange="formulario.submit();">
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>  
      <a href="php-login/cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>
    </header>
    <h1>ADRY-GOL</h1>
<?php if ($nuevaEntrada == true) { ?>
	<h2>Equipos > Nueva ficha de Equipo</h2>
<?php } else { ?>
	<h2>Equipos > Ficha de Equipo</h2>
<?php } ?>

<?php if($equipo[10] != "") { //Aqui mostramos el escudo del equipo, si no tiene mostramos uno por defecto
        echo "<img src='disenio/".$equipo[10]."' width='100' heigth='100'>";
    } else {
        echo "<img src='disenio/fotoEscudo.JPEG' width='100' heigth='100'>";
    }
?>

<form method='post' action='EquipoGuardar.php' enctype="multipart/form-data">

<input type='hidden' name='id_Equipo' value='<?=$id?>' />

    <label for='nombre'>Nombre</label>
    <?php if($nuevaEntrada) { ?>
        <input type='text' name='nombre' placeholder='<?=$equipo[1]?>' />
    <?php } else { ?>
	    <input type='text' name='nombre' value='<?=$equipo[1]?>' />
    <?php } ?>
    <br/>
    <label for='nombre'>Puntos</label>
	<input type='number' name='puntos' value='<?=$equipo[2]?>' readonly/>
    <br/>
    <label for='nombre'>Partidos Jugados</label>
	<input type='number' name='partidosJugados' value='<?=$equipo[3]?>' readonly/>
    <br/>
    <label for='nombre'>Victorias</label>
	<input type='number' name='victorias' value='<?=$equipo[4]?>' readonly/>
    <br/>
    <label for='nombre'>Empates</label>
	<input type='number' name='empates' value='<?=$equipo[5]?>' readonly/>
    <br/>
    <label for='nombre'>Derrotas</label>
	<input type='number' name='derrotas' value='<?=$equipo[6]?>' readonly/>
    <br/>
    <label for='nombre'>Goles a favor</label>
	<input type='number' name='golesFavor' value='<?=$equipo[7]?>' readonly/>
    <br/>
    <label for='nombre'>Goles en contra</label>
	<input type='number' name='golesContra' value='<?=$equipo[8]?>' readonly/>
    <br/>
    <label for='nombre'>Diferencia de goles</label>
	<input type='number' name='diferenciaGoles' value='<?=$equipo[9]?>' readonly/>
    <br/>
    <label>Escudo</label>
    <input type="file" name="escudo" id="escudo"><br>

    <br/>

<?php if ($nuevaEntrada) { //si es nueva entrada ponemos boton de crear sino de guardar ?> 
	<input type='submit' name='crear' value='Crear equipo' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<?php if (!$nuevaEntrada) { ?>
    <a href='EquipoEliminar.php?id_Equipo=<?=$id?>'>Eliminar equipo</a>
<?php } ?>

<br />
<br />

<a href='EquipoListado.php'>Volver al listado de equipos.</a>

</body>

</html>