<?php   
    require_once "comunicaBD/DAO.php";
    $id=$_REQUEST["id_arbitro"];
    $eliminacion=DAO::arbitrosEliminarPorID($id);
?>
