<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$id = (int)$_REQUEST["id_Equipo"];
    $nombre= $_REQUEST["nombre"];

    if($_FILES["escudo"]["name"] != "") {
        $escudo= $_FILES["escudo"]["name"];
        $ruta= $_FILES["escudo"]["tmp_name"];
        $destino= "disenio/".$escudo;
        copy($ruta, $destino);
    } else {
        $equipo= DAO::equipoFicha($id);
        $escudo= $equipo[10];
    }

    if($id != -1) {
        $modificacionCorrecta= DAO::equipoActualizarPorID($id, $nombre, $escudo);
        if($modificacionCorrecta)
            redireccionar("EquipoFicha.php?modificacionCorrecta&id_Equipo=".$id);
        else
            redireccionar("EquipoFicha.php?modificacionErronea&id_Equipo=".$id);
    }else {
        $creacionCorrecta= DAO::equipoCrear($nombre, $escudo);
        if($creacionCorrecta)
            redireccionar("EquipoListado.php?creacionCorrecta");
        else
            redireccionar("EquipoListado.php?creacionErronea");
    }
    