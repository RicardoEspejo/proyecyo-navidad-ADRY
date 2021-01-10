<?php
	require_once "comunicaBD/DAO.php";
	
    $id = (int)$_REQUEST["id_Arbitro"];//Recojo el id del arbitro
    
	$nuevaEntrada=DAO::arbitroNuevaEntrada($id);//este metodo sirve para comprobar si el id que recojo por parametro es un -1.Si es un -1 es una nueva entrada.
    $arbitros=DAO::arbitroFicha($id);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL árbitro ficha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if(isset($_SESSION["tema"])){?><!-- Sirve para cambiar el tema elegido -->
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
    <form action='modoOscuroOclaro.php' method="get" name="formulario" class="formulario"><!--Formulario de cambiar el tema -->
        <input type="hidden" name="nombre" value="arbitroFicha.php?id_Arbitro=<?= $id ?>"> <!-- Aqui mando el nombre del archivo actual, por el cual se va a redirigir -->
        <select name="modo" onChange="formulario.submit();"> <!--Select del tema -->
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>  
      <a href="php-login/cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>
    </header>
    <h1>ADRY-GOL</h1>
<?php if ($nuevaEntrada) { ?>
	<h2>Arbitros > Nueva ficha de arbitros</h2>
<?php } else { ?>
	<h2>Arbitros > Ficha de arbitros</h2>
<?php } ?>

<?php if(isset($_REQUEST["modificacionCorrecta"])){ ?>
    <p>
        <h6>Se ha modificado correctamente el arbitro.</h6>
    </p>
    
<?php }else if(isset($_REQUEST["modificacionIncorrecta"])){ ?>
    <p>
        <h6>No se ha podido modificado el arbitro.</h6>
    </p>

<?php } ?>
<form method='post' action='arbitroGuardar.php'>

<input type='hidden' name='id' value='<?=$id?>' />
<?php if ($nuevaEntrada) { ?> 
    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' placeholder='<?= $arbitros->getNombre() ?>' />
    <br/>

    <label for='apellidos'>Apellidos</label>
	<input type='text' name='apellidos' placeholder='<?= $arbitros->getApellidos() ?>' />
    <br/>

    <br/>
    <input type='submit' name='crear' value='Crear arbitros' />
<?php } else { ?>
    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' value='<?= $arbitros->getNombre() ?>' />
    <br/>

    <label for='apellidos'>Apellidos</label>
	<input type='text' name='apellidos' value='<?= $arbitros->getApellidos() ?>' />
    <br/>

    <br/>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<a href='arbitroListado.php'>Volver al listado de arbitros.</a>

</body>

</html>