<?php
require_once "comunicaBD/DAO.php";

$arbitros = DAO::arbitroObtenerTodos();

if (isset($_REQUEST["buscar"])) { //Si existe buscar es por que le han dado al boton de buscar
    $buscar = strtolower($_REQUEST["buscar"]);
    $buscador = true;
    $buscarArbitro = DAO::buscarArbitros($buscar, str_word_count($buscar, 0));
} else {
    $buscador = false;
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL árbitro listado</title>
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
<?php if(isset($_REQUEST["creacionCorrecta"])){ ?>
    <p>
        <h6>Se ha creado correctamente el arbitro.</h6>
    </p>
<?php }else if(isset($_REQUEST["creacionIncorrecta"])){ ?>
    <p>
        <h6>No se ha podido crear el arbitro.</h6>
    </p>

<?php }else if(isset($_REQUEST["eliminacionCorrecta"])){ ?>
    <p>
        <h6>Se ha eliminado correctamente el arbitro.</h6>
    </p>
<?php }else if(isset($_REQUEST["eliminacionIncorrecta"])){ ?>
    <p>
        <h6>No se ha podido eliminar el arbitro.</h6>
    </p>
<?php } ?>


    <header>
    <a href='php-login/inicio.php' class="menuPrincipal">Menu Principal</a>
    <form action='modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
        <input type="hidden" name="nombre" value="arbitroListado.php">
        <select name="modo" onChange="formulario.submit();">
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>  
      <a href="php-login/cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>
    </header>
   <div class="contenedor">   
        <h1>ADRY-GOL</h1>

        <div class="contenedor2">
        <h2>Arbitros > Listado</h2>
    <form action='' method='post' class="buscador2">
        <?php if ($buscador == true) {  ?>
            <input type="search" placeholder="Buscar" name="buscar" value="<?= $buscar  ?>" class="buscador">
            <a href="ArbitroListado.php"><img src="disenio/delete.png" alt="volver al listado" height="22px" class="deleteArbitro "></a>
        <?php } else { ?>
            <input type="search" placeholder="Buscar" name="buscar" class="buscador">
        <?php } ?>
        <input type="submit" value="Buscar">
    </form>
    </div>
    <?php if ($buscador == true) { ?>
        <?php if (count($buscarArbitro) >= 1) { ?>
            <p>
            <h4>Resultados de la busqueda: <?= count($buscarArbitro) ?></h4>
            </p>
            <table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                        <th>Eliminar</th>
                    <?php } ?>
                </tr>
                <?php foreach ($buscarArbitro as $arbitro) { ?>
                    <tr>
                    <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { //Aqui comprobamos si tiene permisos de administrador ?>
                            <td><a href='arbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getNombre() ?> </a></td>
                            <td><a href='arbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getApellidos() ?> </td>
                            <td><a href='arbitroEliminar.php?id_arbitro=<?= $arbitro->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                        <?php } else {?>
                            <td> <?= $arbitro->getNombre() ?> </td>
                            <td> <?= $arbitro->getApellidos() ?> </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <p>
                <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                <?php header("refresh:5;url=arbitroListado.php") ?>
                </p>
            <?php } ?>
            </table><br>
        <?php } else { ?>
            <table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                        <th>Eliminar</th>
                    <?php } ?>
                </tr>
                <?php foreach ($arbitros as $arbitro) { ?>
                    <tr>
                    <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { //Aqui comprobamos si tiene permisos de administrador ?>
                            <td><a href='arbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getNombre() ?> </a></td>
                            <td><a href='arbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getApellidos() ?> </td>
                            <td><a href='arbitroEliminar.php?id_arbitro=<?= $arbitro->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                        <?php } else {?>
                            <td> <?= $arbitro->getNombre() ?> </td>
                            <td> <?= $arbitro->getApellidos() ?> </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>
            </table><br>
            </div>
            <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                <a href='arbitroFicha.php?id_Arbitro=-1'>Crear entrada</a>
            <?php } ?>
            
                
</body>

</html>