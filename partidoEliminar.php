<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

    $id = (int)$_REQUEST["id_Partido"];
    $eliminacionCorrecta = DAO::partidoEliminarPorID($id);

    if($eliminacionCorrecta)
        redireccionar("partidoListado.php?eliminacionCorrecta");
    else
        redireccionar("partidoListado.php?eliminacionErronea");