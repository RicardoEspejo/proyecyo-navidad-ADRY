<?php   
    require_once "comunicaBD/DAO.php";
    $id=$_REQUEST["id_Arbitro"];
    $eliminacion=DAO::arbitrosEliminarPorID($id);
?>
