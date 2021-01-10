<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    //RECOGE EL ID DE PARTIDO
    $id = (int)$_REQUEST["id_Partido"];

    //CONECTA CON EL MÉTODO DE ELIMINACIÓN DEL DAO
    $eliminacionCorrecta = DAO::partidoEliminarPorID($id);

    //REDIRIGE A PARTIDO LISTADO PARA MOSTRAR ALLI SI SE HA ELIMINADO CORRECTAMENTE
    if($eliminacionCorrecta)
        redireccionar("partidoListado.php?eliminacionCorrecta");
    else
        redireccionar("partidoListado.php?eliminacionErronea");