<?php
require_once "comunicaBD/DAO.php";

$arbitros = DAO::arbitroObtenerTodos();

if (isset($_REQUEST["buscar"])) {
    $buscar = strtolower($_REQUEST["buscar"]);
    $buscador = true;
    $buscarArbitro = DAO::buscarArbitros($buscar, str_word_count($buscar, 0));
} else {
    $buscador = false;
}
?>
<html>

<head>
    <title>Arbitros Listado</title>
    <meta http-equiv=”Content-Language” content=”es” />
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
        <a href='/proyectoClase/proyecyo-navidad-ADRY/php-login/inicio.php' class="menuPrincipal">Menu Principal</a>
    <form action='modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
        <input type="hidden" name="nombre" value="arbitroListado.php">
        <select name="modo" onChange="formulario.submit();">
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>  
      <a href="../proyecyo-navidad-ADRY/php-login/cerrarSesion.php" class="cerrarSesion">Cerrar Sesión</a>
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
                    <th>Eliminar</th>
                </tr>
                <?php foreach ($buscarArbitro as $arbitro) { ?>
                    <tr>
                        <td><a href='ArbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getNombre() ?> </a></td>
                        <td><a href='ArbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getApellidos() ?> </td>
                        <td><a href='arbitroEliminar.php?id_arbitro=<?= $arbitro->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <p>
                <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                <?php header("refresh:5;url=ArbitroListado.php") ?>
                </p>
            <?php } ?>
            </table><br>
        <?php } else { ?>
            <table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Eliminar</th>
                </tr>
                <?php foreach ($arbitros as $arbitro) { ?>
                    <tr>
                        <td><a href='ArbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getNombre() ?> </a></td>
                        <td><a href='ArbitroFicha.php?id_Arbitro=<?= $arbitro->getId() ?>'> <?= $arbitro->getApellidos() ?> </td>
                        <td><a href='ArbitroEliminar.php?id_arbitro=<?= $arbitro->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"> </a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </table><br>
            </div>
            <a href='ArbitroFicha.php?id_Arbitro=-1'>Crear entrada</a>
                
</body>

</html>