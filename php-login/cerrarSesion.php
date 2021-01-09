<?php

require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";

//ESTE PHP SIRVE PARA CERRAR LA SESIÓN INICIADA. 
//LE LLAMAMOS DESDE LOS LIK QUE HAY EN CADA PHP.

DAO::CerrarSesion();

redireccionar("../php-login");
