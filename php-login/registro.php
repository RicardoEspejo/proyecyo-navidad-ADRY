<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";


$mnsj = "";
$exito = "";

if (!empty($_POST['identificador']) && !empty($_POST['contrasenna'])) {
    $identificador = $_POST['identificador'];
    $confirmar_contrasenna = $_POST['confirmar_contrasenna'];
    $tipo = (isset($_POST["tipo"])) ? '1' : '0';

    if ($_POST['contrasenna'] == $confirmar_contrasenna) {
        $contrasenna = password_hash($_POST['contrasenna'], PASSWORD_BCRYPT);
        DAO::usuarioCrear($identificador, $contrasenna, $tipo);
    } else {
        $mnsj = "La contraseña ha fallado";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
</head>

<body>
    <header>
        <a href="../php-login">Fútbol de Barrio</a>
    </header>
    <h1>Liga de fútbol de Barrio</h1>
    <h3>Registrarse</h3>
    <span>o<a href="inicioSesion.php"> Iniciar Sesión</a></span>
    <p></p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="usuario">Nombre de Usuario: </label>
        <input type="text" name="identificador" placeholder="Usuario" required>
        <p></p>
        <label for="contrasenna">Contraseña: </label>
        <input type="password" name="contrasenna" placeholder="Contraseña" required>
        <p></p>
        <label for="confirmar_contrasenna">Repetir Contraseña: </label>
        <input type="password" name="confirmar_contrasenna" placeholder="Repite la contraseña" required>
        <p></p>
        <label for="arbitro">¿Eres un Administrador?</label>
        <input type="checkbox" name="tipo" value="administrador">
        <p></p>
        <input type="submit" value="Registrarse">
    </form>
    <?php if (!empty($mnsj)) : ?>
        <p style="color:red"><?= $mnsj ?></p>
    <?php endif; ?>
</body>

</html>