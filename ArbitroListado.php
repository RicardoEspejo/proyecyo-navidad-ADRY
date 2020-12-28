<?php
        require_once "comunicaBD/DAO.php";

        $arbitros=DAO::arbitroObtenerTodos();
?>
<html>
    <head>
        <title>Arbitros Listado</title>
        <meta http-equiv=”Content-Language” content=”es”/>
    </head>
    <body> 
        <h1>Listado de Arbitros</h1>
        <table border='1'>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($arbitros as $arbitro) { ?>
                <tr>
                    <td><a href='ArbitroFicha.php?id_Arbitro=<?=$arbitro->getId()?>'> <?=$arbitro->getNombre()?> </a></td>
                    <td><a href='ArbitroFicha.php?id_Arbitro=<?=$arbitro->getId()?>'> <?=$arbitro->getApellidos()?> </td>
                    <td><a href='ArbitroEliminar.php?id=<?=$arbitro->getId()?>'> (X)  </a></td>
                </tr>
            <?php } ?>

        </table><br>
        <a href='ArbitroFicha.php?id=-1'>Crear entrada</a>
    </body>
</html>