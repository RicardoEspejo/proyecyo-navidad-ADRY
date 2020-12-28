<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $id = (int)$_REQUEST["id_Equipo"];
    $eliminacionCorrecta = DAO::equipoEliminarPorID($id);

    if($eliminacionCorrecta)
        redireccionar("EquipoListado.php?eliminacionCorrecta");
    else
        redireccionar("EquipoListado.php?eliminacionErronea");