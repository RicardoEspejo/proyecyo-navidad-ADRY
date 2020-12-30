<?php
	require_once "comunicaBD/DAO.php";
	
    $id = (int)$_REQUEST["id_Arbitro"];
    
	$nuevaEntrada=DAO::arbitroNuevaEntrada($id);
	$arbitros=DAO::arbitroFicha($id);
?>
<html>

<head>
        <meta charset="utf-8">
        <title>ADRY-GOL</title>
        <link rel="stylesheet" href="disenio/ADRY.css">
</head>

<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de categoría</h1>
<?php } else { ?>
	<h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='arbitroGuardar.php'>

<input type='hidden' name='id' value='<?=$id?>' />
<?php if ($nuevaEntrada) { ?>
    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' placeholder='<?= $arbitros[0] ?>' />
    <br/>

    <label for='apellidos'>Apellidos</label>
	<input type='text' name='apellidos' placeholder='<?= $arbitros[1]?>' />
    <br/>

    <br/>
    <input type='submit' name='crear' value='Crear arbitros' />
<?php } else { ?>
    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' value='<?= $arbitros[0] ?>' />
    <br/>

    <label for='apellidos'>Apellidos</label>
	<input type='text' name='apellidos' value='<?= $arbitros[1] ?>' />
    <br/>

    <br/>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<a href='ArbitroListado.php'>Volver al listado de arbitros.</a>

</body>

</html>