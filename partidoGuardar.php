<?php
require_once "comunicaBD/dao.php";

$id_Partido = $_REQUEST["id_Partido"];
$id_Equipo_Local = $_REQUEST["equipoLocalId"];
$id_Equipo_Visitante = $_REQUEST["equipoVisitanteId"];
$fecha = $_REQUEST["fecha"];
$id_Arbitro = $_REQUEST["arbitroId"];
$gol_Local = $_REQUEST["gol_Local"];
$gol_Visitante = $_REQUEST["gol_Visitante"];
$ganador = $_REQUEST["ganador"];

$partido = DAO::partidoFicha($id_Partido);

if ($id_Partido != -1) {
    
    //Para que cada vez que se modifiquen los partidos solo sumen o resten las diferencias
    $gol_Local_Antiguo= $partido[5];
    $gol_Visitante_Antiguo= $partido[6];
    if($gol_Local_Antiguo < $gol_Local)
        $gol_Local_Nuevo = $gol_Local - $gol_Local_Antiguo;
    elseif($gol_Local_Antiguo > $gol_Local)
        $gol_Local_Nuevo = $gol_Local_Antiguo - $gol_Local;
    else
        $gol_Local_Nuevo = 0;
    
    if($gol_Visitante_Antiguo < $gol_Visitante)
        $gol_Visitante_Nuevo = $gol_Visitante - $gol_Visitante_Antiguo;
    elseif($gol_Visitante_Antiguo > $gol_Visitante)
        $gol_Visitante_Nuevo = $gol_Visitante_Antiguo - $gol_Visitante;
    else
        $gol_Visitante_Nuevo = 0;
    
    $modificacionCorrecta = DAO::partidoActualizarPorID(
        $id_Partido,
        $id_Equipo_Local,
        $id_Equipo_Visitante,
        $fecha,
        $id_Arbitro,
        $gol_Local,
        $gol_Visitante
    );
    if ($modificacionCorrecta) {
        //MODIFICA LAS ESTADÍSTICAS DE LOS EQUIPOS PARA UNA VICTORIA LOCAL
        if ($gol_Local > $gol_Visitante) {
            DAO::establecerVictoriaLocal($id_Equipo_Local, $gol_Local_Nuevo, $gol_Visitante_Nuevo, $id_Partido);
            DAO::establecerDerrotaVisitante($id_Equipo_Visitante, $gol_Local_Nuevo, $gol_Visitante_Nuevo, $id_Partido);
            DAO::partidoActualizarGanador(1, $id_Partido);
        }
        //MODIFICA LAS ESTADÍSTICAS DE LOS EQUIPOS PARA UN EMPATE
        if ($gol_Local == $gol_Visitante) {
            DAO::establecerEmpateLocal($id_Equipo_Local, $gol_Local_Nuevo, $gol_Visitante_Nuevo, $id_Partido);
            DAO::establecerEmpateVisitante($id_Equipo_Visitante, $gol_Local_Nuevo, $gol_Visitante_Nuevo, $id_Partido);
            DAO::partidoActualizarGanador(0, $id_Partido);
        }
        //MODIFICA LAS ESTADÍSTICAS DE LOS EQUIPOS PARA UNA VICTORIA VISITANTE
        if ($gol_Local < $gol_Visitante) {
            DAO::establecerVictoriaVisitante($id_Equipo_Visitante, $gol_Local_Nuevo, $gol_Visitante_Nuevo, $id_Partido);
            DAO::establecerDerrotaLocal($id_Equipo_Local, $gol_Local_Nuevo, $gol_Visitante_Nuevo, $id_Partido);
            DAO::partidoActualizarGanador(2, $id_Partido);
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