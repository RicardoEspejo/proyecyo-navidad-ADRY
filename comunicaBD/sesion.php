<?php

// require_once "DAO.php";
// require_once "clases.php";

// function sessionStartSiNoLoEsta()
// {
//     if (!isset($_SESSION)) {
//         session_start();
//     }
// }

// function haySesionIniciada()
// {
//     sessionStartSiNoLoEsta();
//     return isset($_SESSION['sesionIniciada']);
// }

// function vieneFormularioDeInicioDeSesion()
// {
//     return isset($_REQUEST['identificador']);
// }

// function vieneCookieRecuerdame()
// {
//     return isset($_COOKIE["identificador"]);
// }

// function garantizarSesion()
// {
//     sessionStartSiNoLoEsta();

//     if (haySesionRamIniciada()) {
//         // Si hay cookie de "recuérdame", la renovamos.
//         if (vieneCookieRecuerdame()) {
//             establecerCookieRecuerdame($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);
//         }

//         // >>> NO HACEMOS NADA MÁS. DEJAMOS QUE SE CONTINÚE EJECUTANDO EL PHP QUE NOS LLAMÓ... >>>
//     } else { // NO hay sesión iniciada.
//         if (vieneFormularioDeInicioDeSesion()) { // SÍ hay formulario enviado. Lo comprobaremos contra la BD.
//             $identificador = DAO::usuarioObtenerPorIdentificadorYcontrasenna($_REQUEST['identificador'], $_REQUEST['contrasenna']);

//             if ($identificador) { // Si viene un cliente es que el inicio de sesión ha sido exitoso.
//                 anotarDatosSesionRam($identificador);
                
//                 if (isset($_REQUEST["recuerdame"])) { // Si han marcado el checkbox de recordar:
//                     generarCookieRecuerdame($identificador);
//                 }
//                 // >>> Y DEJAMOS QUE SE CONTINÚE EJECUTANDO EL PHP QUE NOS LLAMÓ... >>>
//             } else { // Si cliente es null, o no existe ese cliente o la contraseña no coincide.
//                 redireccionar("../php-login/inicioSesion.php");
//             }
//         } else if (vieneCookieRecuerdame()) {
//             $identificador = DAO::usuarioObtenerPorIdentificadorYCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]); // TODO Hacer esto con DAO.

//             if ($identificador) { // Si viene un cliente es que existe el cliente y coincide el código cookie. Daremos por iniciada la sesión.
//                 // Recuperar los datos adicionales del usuario que acaba de iniciar sesión.
//                 anotarDatosSesionRam($identificador);

//                 // Renovar la cookie (código y caducidad).
//                 generarCookieRecuerdame($identificador);
//             } else { // Parecía que venía una cookie válida pero... No es válida o pasa algo raro.
//                 // Borrar la cookie mala que nos están enviando (si no, la enviarán otra vez, y otra, y otra...)
//                 borrarCookieRecuerdame($identificador->getIdentificador());

//                 // REDIRIGIR A INICIAR SESIÓN PARA IMPEDIR QUE ESTE USUARIO VISUALICE CONTENIDO PRIVADO.
//                 redireccionar("../php-login/inicioSesion.php");
//             }
//         } else { // NO hay ni sesión, ni cookie, ni formulario enviado.
//             // REDIRIGIMOS PARA QUE NO SE VISUALICE CONTENIDO PRIVADO:
//             redireccionar("../php-login/inicioSesion.php");
//         }
//     }
// }

// function establecerCookieRecuerdame($identificador, $codigoCookie)
// {
//     // Enviamos el código cookie al cliente, junto con su identificador.
//     setcookie("identificador", $identificador, time() + 24*60*60); // Un mes sería: +30*24*60*60
//     setcookie("codigoCookie", $codigoCookie, time() + 24*60*60); // Un mes sería: +30*24*60*60
// }


// function generarCookieRecuerdame($identificador)
// {
//     // Creamos un código cookie muy complejo (no necesariamente único).
//     $codigoCookie = generarCadenaAleatoria(32); // Random...
//     DAO::usuarioGuardarCodigoCookie($identificador->getIdentificador(), $codigoCookie);

//     // TODO Para una seguridad óptima convendriá anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.

//     establecerCookieRecuerdame($identificador->getIdentificador(), $codigoCookie);
// }

// function borrarCookieRecuerdame($identificador)
// {
//     // Eliminamos el código cookie de nuestra BD.
//     DAO::usuarioGuardarCodigoCookie($identificador, null);

//     setcookie("identificador", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
//     setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
// }

// function anotarDatosSesionRam($identificador)
// {
//     $_SESSION["sesionIniciada"] = "";
//     $_SESSION["id"] = $identificador->getId();
//     $_SESSION["identificador"] = $identificador->getIdentificador();
// }

// function destruirSesionYCookies($identificador)
// {
//     session_destroy();

//     borrarCookieRecuerdame($identificador);
// } 