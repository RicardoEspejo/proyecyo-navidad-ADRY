<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";


if (isset($_SESSION["id_Usuario"])) {
    redireccionar("inicio.php");
}

$mnsj = "";

if (!empty($_POST['identificador']) && !empty($_POST['contrasenna'])) {
    $identificador = $_POST['identificador'];
    $password = $_POST['contrasenna'];
    $resultado = DAO::iniciarSesionUsuario($identificador);

    if (count($resultado) > 0 && password_verify($password, $resultado[2])) {
        if (!empty($_POST["recuerdame"])) {
            setcookie("identificador", $identificador, time() + (10 * 365 * 24 * 60 * 60));
            setcookie("contrasenna", $password, time() + (10 * 365 * 24 * 60 * 60));
            $_SESSION['id_Usuario'] = $resultado[0];
        } else {
            if (isset($_COOKIE["identificador"])) {
                setcookie("identificador", "");
                $_SESSION['id_Usuario'] = $resultado[0];
            }
            if (isset($_COOKIE["contrasenna"])) {
                setcookie("contrasenna", "");
                $_SESSION['id_Usuario'] = $resultado[0];
            }
        }
        header('Location: inicio.php');
    } else {
        $mnsj = "Error en el inicio de Sesion, estás credenciales no coinciden";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADRY-GOL inicio sesión</title>
    <?php if(isset($_SESSION["tema"])){?>
    <?php if($_SESSION["tema"] == "claro"){ ?>
        <link rel='stylesheet' href='../disenio/modoClaro.css'>
    <?php }else{ ?>
        <link rel='stylesheet' href='../disenio/modoOscuro.css'>
    <?php } }else{?>
        <link rel='stylesheet' href='../disenio/modoClaro.css'>
    <?php } ?>
</head>

<body>
    <header>
    <form action='../modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
        <input type="hidden" name="nombre" value="php-login/inicioSesion.php">
        <select name="modo" onChange="formulario.submit();">
            <option value="claro" <?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "claro"){?> selected <?php } } ?>>Tema Claro</option>
            <option value="oscuro"<?php if(isset($_SESSION["tema"])){if($_SESSION["tema"]== "oscuro"){?> selected <?php } } ?>>Tema Oscuro</option>
         </select>
         </form>
    </header>
    <h1>ADRY-GOL</h1>
    <h2>INICIA SESIÓN</h2>
    <span>o<a href="registro.php"> Registrarse </a></span>
    <p></p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="usuario">Nombre de Usuario: </label>
        <input type="text" name="identificador" placeholder="Usuario" value="<?php if (isset($_COOKIE["identificador"])) {
                                                                                    echo $_COOKIE["identificador"];
                                                                                } ?>">
        <p></p>
        <label for="contrasenna">Contraseña: </label>
        <input type="password" name="contrasenna" placeholder="Contraseña" value="<?php if (isset($_COOKIE["contrasenna"])) {
                                                                                        echo $_COOKIE["contrasenna"];
                                                                                    } ?>">
        <p></p>
        <label><b>Recuérdame</b></label>
        <input type="checkbox" name="recuerdame" <?php if (isset($_COOKIE["identificador"])) { ?>checked<?php } ?>><br />
        <input type="submit" value="Iniciar Sesión">
    </form>

    <?php if (!empty($mnsj)) : ?>
        <p style="color:red"><?= $mnsj ?></p>
    <?php endif; ?>
</body>

</html>