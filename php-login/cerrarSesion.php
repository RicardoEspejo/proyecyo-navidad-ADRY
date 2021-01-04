<?php

require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";


DAO::CerrarSesion();

redireccionar("../php-login");
