<?php
    require_once "comunicaBD/DAO.php";

    $nombre=$_REQUEST["nombre"];
    $modo=$_REQUEST["modo"];

    DAO::modoClaroOscuro($modo);
    redireccionar($nombre);