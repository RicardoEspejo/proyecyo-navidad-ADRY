<?php
    require_once "comunicaBD/DAO.php";

    $id=$_REQUEST["id"];
    $nombre=$_REQUEST["nombre"];
    $apellidos=$_REQUEST["apellidos"];

    $arbitros=DAO::arbitrosGuardar($id,$nombre,$apellidos);
?>
