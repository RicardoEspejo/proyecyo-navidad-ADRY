<?php
	require_once "comunicaBD/varios.php";
	require_once "comunicaBD/dao.php";

	$id = (int)$_REQUEST["id_Equipo"];
    $nombre= $_REQUEST["nombre"];

    if($_FILES["escudo"]["name"] != "") { //Aqui comprobamos si se modifica el escudo, si no se queda con el que estaba
        $escudo= $_FILES["escudo"]["name"];
        $ruta= $_FILES["escudo"]["tmp_name"];
        $destino= "disenio/".$escudo;
        copy($ruta, $destino);
    } else {
        $equipo= DAO::equipoFicha($id);
        $escudo= $equipo[10];
    }

    $puntos= $_REQUEST["puntos"];
    $partidosJugados= $_REQUEST["partidosJugados"];
    $victorias= $_REQUEST["victorias"];
    $empates= $_REQUEST["empates"];
    $derrotas= $_REQUEST["derrotas"];
    $golesFavor= $_REQUEST["golesFavor"];
    $golesContra= $_REQUEST["golesContra"];
    $diferenciaGoles= $_REQUEST["diferenciaGoles"];

    if($id != -1) { //si no es un nueva entrada estamos modificando y si no lo estamos creando e indicamos si se ha hecho correctaente o no
        $modificacionCorrecta= DAO::equipoActualizarPorId($id, $nombre, $escudo, $puntos, $partidosJugados, $victorias, 
        $empates, $derrotas, $golesFavor, $golesContra, $diferenciaGoles);
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
    