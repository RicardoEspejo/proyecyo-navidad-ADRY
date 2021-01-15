<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $id = (int)$_REQUEST["id_Equipo"];
    $eliminacionCorrecta = DAO::equipoEliminarPorID($id); //Eliminamos el equipo que tenga este Id

    if($eliminacionCorrecta)
        redireccionar("EquipoListado.php?eliminacionCorrecta"); //Si la eliminiacion es correcta lo indicamos
    else
        redireccionar("EquipoListado.php?eliminacionErronea"); //Y si falla lo indicamos también