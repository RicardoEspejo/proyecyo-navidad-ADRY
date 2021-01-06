<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";

session_start();

if (isset($_SESSION["id_Usuario"])) {
    redireccionar("inicio.php");
}

//cookies   





$mnsj = "";

if (!empty($_POST['identificador']) && !empty($_POST['contrasenna'])) {
    $identificador = $_POST['identificador'];
    $password = $_POST['contrasenna'];
    $resultado = DAO::iniciarSesionUsuario($identificador);

    if (count($resultado) > 0 && password_verify($password, $resultado[2])) {
        $_SESSION['id_Usuario'] = $resultado[0];
        if ($_POST["recuerdame"] == "1") {
            $numero_aleatorio = generarCadenaAleatoria(50);
            $year = time() + 31536000;

            DAO::usuarioActualizarPorIdLasCookies($resultado[0], $numero_aleatorio);
            if ($_POST["recuerdame"]) {
                setcookie("recuerdame", $identificador, $year);
            } elseif (!$_POST["recuerdame"]) {
                if (isset($_COOKIE["recuerdame"])) {
                    $past = time() - 100;
                    setcookie("recuerdame", $identificador, $past);
                }
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
    <meta charset="UTF-8">
    <title>Inicar Sesión</title>
</head>

<body>
    <header>
        <a href="../php-login">ADRYGOL</a>
    </header>
    <h1>Liga ADRYGOL</h1>
    <h3>Inicia Sesión</h3>
    <span>o<a href="registro.php"> Registrarse </a></span>
    <p></p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="usuario">Nombre de Usuario: </label>
        <input type="text" name="identificador" placeholder="Usuario" >
        <p></p>
        <label for="contrasenna">Contraseña: </label>
        <input type="password" name="contrasenna" placeholder="Contraseña">
        <p></p>
        <label><b>Recuérdame</b></label>
        <input type="checkbox" name="recuerdame" <?php $condicion = isset($_COOKIE["recuerdame"]) ? "checked='checked'" :  ""; ?>><br />
        <input type="submit" value="Iniciar Sesión">
    </form>

    <?php if (!empty($mnsj)) : ?>
        <p style="color:red"><?= $mnsj ?></p>
    <?php endif; ?>
</body>

</html>