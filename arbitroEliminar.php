<?php   
    require_once "comunicaBD/DAO.php";
    $id=$_REQUEST["id_arbitro"];//Recojo el id del arbitro
    $eliminacion=DAO::arbitrosEliminarPorID($id);//metodo de eliminacion del arbitro por id
?>
