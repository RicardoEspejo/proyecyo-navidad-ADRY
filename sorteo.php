<?php
    require_once "comunicaBD/varios.php";
    require_once "comunicaBD/dao.php";
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 0) {
        redireccionar("php-login/inicio.php?noPermisos");
    }
    DAO::sorteo();
    redireccionar("partidoListado.php");
?>