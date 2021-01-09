<?php
require_once "../comunicaBD/DAO.php";
require_once "../comunicaBD/varios.php";


$mnsj = "";
$exito = "";
//COMPROBAMOS QUE LOS CAMPOS NO ESTAN VACIOS
if (!empty($_POST['identificador']) && !empty($_POST['contrasenna'])) {
    $identificador = $_POST['identificador'];
    $confirmar_contrasenna = $_POST['confirmar_contrasenna'];
    // SI ESTA MARCADO ALMACENAMOS 1 (ADMINISTRADOR) SI NO 0 (USAURIO)
    $tipo = (isset($_POST["tipo"])) ? '1' : '0';
    //COMPROBAMOS QUE COINCIDAN LAS COTRASENNAS
    if ($_POST['contrasenna'] == $confirmar_contrasenna) {
        // sI COINCIDE LA HASHEAMOS 
        $contrasenna = password_hash($_POST['contrasenna'], PASSWORD_BCRYPT);
        // UNA VEZ HASHEADO CREAMOS EL USUARIO
        DAO::usuarioCrear($identificador, $contrasenna, $tipo);
        // UNA VEZ CREADO LE REDIRIGIMOS AL INICIO SESION
        redireccionar("inicioSesion.php");
    } else {
        //ERROR EN LA CONTRASEÑA
        $mnsj = "La contraseña ha fallado";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ADRY-GOL registro</title>
<?php if (isset($_SESSION["tema"])) { ?>
    <?php if ($_SESSION["tema"] == "claro") { ?>
        <link rel='stylesheet' href='../disenio/modoClaro.css'>
    <?php } else { ?>
        <link rel='stylesheet' href='../disenio/modoOscuro.css'>
    <?php }
} else { ?>
    <link rel='stylesheet' href='../disenio/modoClaro.css'>
<?php } ?>
</head>

<body>
    <header>
        <form action='../modoOscuroOclaro.php' method="get" name="formulario" class="formulario">
            <input type="hidden" name="nombre" value="php-login/registro.php">
            <select name="modo" onChange="formulario.submit();">
                <option value="claro" <?php if (isset($_SESSION["tema"])) {
                                            if ($_SESSION["tema"] == "claro") { ?> selected <?php }
                                                                                                                } ?>>Tema Claro</option>
                <option value="oscuro" <?php if (isset($_SESSION["tema"])) {
                                            if ($_SESSION["tema"] == "oscuro") { ?> selected <?php }
                                                                                                                } ?>>Tema Oscuro</option>
            </select>
        </form>
    </header>
    <h1>ADRY-GOL</h1>
    <h2>REGISTRO</h2>
    <!-- DAMOS LA OPCION A INICIAR SESION -->
    <span>o<a href="inicioSesion.php"> Iniciar Sesión</a></span>
    <p></p>
    <!-- FORMULARIO PARA REGISTRARTE -->
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
    <!-- EN CASO DE QUE NO COINCIDA MUESTRA ESTE MENSAJE -->
    <?php if (!empty($mnsj)) : ?>
        <p style="color:red"><?= $mnsj ?></p>
    <?php endif; ?>
</body>

</html>