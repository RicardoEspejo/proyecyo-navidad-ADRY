<?php
    require_once "comunicaBD/varios.php";
    require_once "comunicaBD/dao.php";

    //SI INTENTA GENERAR EL SORTEO UN USUARIO QUE NO SEA ÁRBITRO (ADMIN), NO PERMITE SU EJECUCIÓN
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 0) {
        redireccionar("php-login/inicio.php?noPermisos");
    }
    
    //LLAMA AL MÉTODO DE GENERAR EL SORTEO DEL DAO Y REDIRECCIONA AL LISTADO DE PARTIDOS
    DAO::sorteo();
    redireccionar("partidoListado.php");
?>