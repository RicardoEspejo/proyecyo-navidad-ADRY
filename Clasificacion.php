<?php
require_once "comunicaBD/varios.php";
require_once "comunicaBD/dao.php";

$equipos = DAO::ClasificacionObtener();

if (isset($_REQUEST["buscar"])) {
    $buscar = strtolower($_REQUEST["buscar"]);
    $buscador = true;
        if(!empty($buscar)){
            $buscarEquipo = DAO::buscarEquipos($buscar);
        }else{
            redireccionar("Clasificacion.php");
        }
} else {
    $buscador = false;
}
$numero=1;
?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL clasificación</title>
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
        <input type="hidden" name="nombre" value="Clasificacion.php">
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

        <h2>Equipos > Clasificacion</h2>
    <form action='' method='post' class="buscador2">
        <?php if ($buscador == true) {  ?>
            <input type="search" placeholder="Buscar" name="buscar" value="<?= $buscar  ?>" class="buscador">
            <a href="Clasificacion.php"><img src="disenio/delete.png" alt="volver al listado" height="22px" class="deleteArbitro "></a>
        <?php } else { ?>
            <input type="search" placeholder="Buscar" name="buscar" class="buscador">
        <?php } ?>
        <input type="submit" value="Buscar">
    </form>
        </div>
    <?php if ($buscador == true) { ?>
        <?php if (count($buscarEquipo) >= 1) { ?>
            <p>
            <h4>Resultados de la busqueda: <?= count($buscarEquipo) ?></h4>
            </p>
            <table border='1'>
                <tr>
                    <th>Posicion</th> 
                    <th>Nombre</th>
                    <th>Puntos</th>
                    <th>Partidos Jugados</th>
                    <th>Victorias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                    <th>Goles A Favor</th>
                    <th>Goles En Contra</th>
                    <th>Diferencia De Goles</th>
                </tr>
                <?php foreach ($buscarEquipo as $equipo) { //Para obtener en que posicion se encuentra ?>
                    <?php 
                        foreach($equipos as $equipo2){
                            $idEquipo=$equipo2->getId();
                            if($idEquipo == $equipo->getId()){
                                $numeros=$numero;
                            }
                            $numero++;
                        }?>
                    <tr>
                        <td><?php echo $numeros ?></td>
                        <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                            <td><a href='EquipoFicha.php?id_Equipo=<?= $equipo->getId() ?>'> <?= $equipo->getNombre() ?> </a></td>
                        <?php } else {?>
                            <td> <?= $equipo->getNombre() ?> </td>
                        <?php } ?>
                        <td> <?= $equipo->getPuntos() ?> </td>
                        <td> <?= $equipo->getPartidosJugados() ?> </td>
                        <td> <?= $equipo->getVictorias() ?> </td>
                        <td> <?= $equipo->getEmpates() ?> </td>
                        <td> <?= $equipo->getDerrotas() ?> </td>
                        <td> <?= $equipo->getGolesFavor() ?> </td>
                        <td> <?= $equipo->getGolesContra() ?> </td>
                        <td> <?= $equipo->getDiferenciaGoles() ?> </td>
                        <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                            <td><a href='EquipoEliminar.php?id_Equipo=<?= $equipo->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"></a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>


            <?php } else { ?>
                <p>
                <h3>No se ha encontrado resultados de la busqueda <?= $buscar ?> </h3>
                <?php header("refresh:5;url=Clasificacion.php") ?>
                </p>
            <?php } ?>
        <?php } else { ?>
            <table border='1'>
                <tr>
                    <th>Posicion</th>
                    <th>Nombre</th>
                    <th>Puntos</th>
                    <th>Partidos Jugados</th>
                    <th>Victorias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                    <th>Goles A Favor</th>
                    <th>Goles En Contra</th>
                    <th>Diferencia De Goles</th>
                </tr>
                <?php foreach ($equipos as $equipo) { ?>
                    <tr>
                        <td><?php echo $numero ?></td>
                        <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                            <td><a href='EquipoFicha.php?id_Equipo=<?= $equipo->getId() ?>'> <?= $equipo->getNombre() ?> </a></td>
                        <?php } else {?>
                            <td> <?= $equipo->getNombre() ?> </td>
                        <?php } ?>
                        <td> <?= $equipo->getPuntos() ?> </td>
                        <td> <?= $equipo->getPartidosJugados() ?> </td>
                        <td> <?= $equipo->getVictorias() ?> </td>
                        <td> <?= $equipo->getEmpates() ?> </td>
                        <td> <?= $equipo->getDerrotas() ?> </td>
                        <td> <?= $equipo->getGolesFavor() ?> </td>
                        <td> <?= $equipo->getGolesContra() ?> </td>
                        <td> <?= $equipo->getDiferenciaGoles() ?> </td>
                        <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 1) { ?>
                            <td><a href='EquipoEliminar.php?id_Equipo=<?= $equipo->getId() ?>'> <img src="disenio/delete.png" width="25" height="25" alt="eliminar"></a></td>
                        <?php } ?>
                    </tr>
                    <?php $numero++; ?>
                <?php } ?>
            <?php } ?>
            </table><br>
                </div>
</body>

</html>