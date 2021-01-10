<?php
require_once "comunicaBD/dao.php";

$id_Partido = $_REQUEST["id_Partido"];
$id_Equipo_Local = $_REQUEST["equipoLocalId"];
$id_Equipo_Visitante = $_REQUEST["equipoVisitanteId"];
$fecha = $_REQUEST["fecha"];
$id_Arbitro = $_REQUEST["arbitroId"];
$gol_Local = $_REQUEST["gol_Local"];
$gol_Visitante = $_REQUEST["gol_Visitante"];
$ganador = 0;

$partido = DAO::partidoFicha($id_Partido);

if ($id_Partido != -1) {
    $modificacionCorrecta = DAO::partidoActualizarPorID(
        $id_Partido,
        $id_Equipo_Local,
        $id_Equipo_Visitante,
        $fecha,
        $id_Arbitro,
        $gol_Local,
        $gol_Visitante,
        $ganador
    );
    if ($modificacionCorrecta) {
        //MODIFICA LAS ESTADÍSTICAS DE LOS EQUIPOS PARA UNA VICTORIA LOCAL
        if ($gol_Local > $gol_Visitante) {
            $ganador = 1;
            DAO::establecerVictoriaLocal($id_Equipo_Local, $gol_Local, $gol_Visitante);
            DAO::establecerDerrotaVisitante($id_Equipo_Visitante, $gol_Local, $gol_Visitante);
            DAO::partidoActualizarGanador($ganador, $id_Partido);
        }
        //MODIFICA LAS ESTADÍSTICAS DE LOS EQUIPOS PARA UN EMPATE
        if ($gol_Local == $gol_Visitante) {
            $ganador = 0;
            DAO::establecerEmpateLocal($id_Equipo_Local, $gol_Local, $gol_Visitante);
            DAO::establecerEmpateVisitante($id_Equipo_Visitante, $gol_Local, $gol_Visitante);
            DAO::partidoActualizarGanador($ganador, $id_Partido);
        }
        //MODIFICA LAS ESTADÍSTICAS DE LOS EQUIPOS PARA UNA VICTORIA VISITANTE
        if ($gol_Local < $gol_Visitante) {
            $ganador = 2;
            DAO::establecerVictoriaVisitante($id_Equipo_Visitante, $gol_Local, $gol_Visitante);
            DAO::establecerDerrotaLocal($id_Equipo_Local, $gol_Local, $gol_Visitante);
            DAO::partidoActualizarGanador($ganador, $id_Partido);
        } 
        redireccionar("partidoFicha.php?modificacionCorrecta&id_Partido=".$id_Partido); ?>
    <?php } else { 
        redireccionar("partidoFicha.php?modificacionErronea&id_Partido=".$id_Partido); ?>
    <?php }
} else {
    $creacionCorrecta = DAO::partidoCrear(
        $id_Equipo_Local,
        $id_Equipo_Visitante,
        $fecha,
        $id_Arbitro,
        $gol_Local,
        $gol_Visitante,
        $ganador
    );
    if ($creacionCorrecta) { 
        redireccionar("partidoListado.php?modificacionCorrecta"); ?>
    <?php } else
        redireccionar("partidoListado.php?modificacionErronea"); ?>
<?php } ?>