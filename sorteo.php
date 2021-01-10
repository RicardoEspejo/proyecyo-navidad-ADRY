<?php
    require_once "comunicaBD/varios.php";
    require_once "comunicaBD/dao.php";

    //SI INTENTA GENERAR EL SORTEO UN USUARIO QUE NO SEA ÁRBITRO (ADMIN), NO PERMITE SU EJECUCIÓN
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 0) {
        redireccionar("php-login/inicio.php?noPermisos");
    }
    //SI NO HAY ÁRBITRO Y/O EQUIPO CREADOS NO SE PUEDE EJECUTAR EL SORTEO
    $arbitros = DAO:: arbitroObtenerTodos();
    $equipos = DAO:: equipoObtenerTodos();

    if(count($arbitros) == 0 || count($arbitros) == 0) {
        redireccionar("php-login/inicio.php?noDatos");
    }

    else{ //LLAMA AL MÉTODO DE GENERAR EL SORTEO DEL DAO Y REDIRECCIONA AL LISTADO DE PARTIDOS
    DAO::sorteo();
    redireccionar("partidoListado.php");
    }
?>