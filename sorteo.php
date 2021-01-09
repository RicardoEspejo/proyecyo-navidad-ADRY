<?php
    require_once "comunicaBD/varios.php";
    require_once "comunicaBD/dao.php";
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 0) {
        redireccionar("php-login/inicio.php");
    }
    DAO::sorteo();
    redireccionar("partidoListado.php");
?>