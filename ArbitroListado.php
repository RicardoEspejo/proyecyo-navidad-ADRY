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
    <link rel="stylesheet" href="disenio/ADRY.css">
</head>

<body>
    <header>
        <a href='/proyectoClase/proyecyo-navidad-ADRY/php-login/inicio.php'>Fútbol de Barrio</a>
    </header>
    <h1>Listado de Arbitros</h1>
    <form action='' method='post'>
        <?php if ($buscador == true) {  ?>
            <input type="search" placeholder="Buscar" name="buscar" value="<?= $buscar  ?>">
            <a href="ArbitroListado.php"><img src="disenio/delete.png" alt="volver al listado" height="22px" class="deleteArbitro "></a>
        <?php } else { ?>
            <input type="search" placeholder="Buscar" name="buscar">
        <?php } ?>
        <input type="submit" value="Buscar">
    </form>

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
                        <td><a href='arbitroEliminar.php?id_arbitro=<?= $arbitro->getId() ?>'> (X) </a></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <p>
                <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                <?php header("refresh:5;url=ArbitroListado.php") ?>
                </p>
            <?php } ?>
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
                        <td><a href='ArbitroEliminar.php?id_arbitro=<?= $arbitro->getId() ?>'> (X) </a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </table><br>
            <a href='ArbitroFicha.php?id_Arbitro=-1'>Crear entrada</a>
</body>

</html>