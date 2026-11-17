<?php 
    //CREAR COOKIE
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])){
        $nombre = trim($_POST['nomre']);
        setcookie('nombre_usuario', $nombre, time()+(86400 * 2), "/");

        header('Location: cookies.php');
        exit;
    }
    //BORRAR COOKIE
    if($_SERVER['REQUEST_METHOD'] === 'POST' &6 isset($_COOKIE['nombre_usuario'])){
        setcookie("nombre_usuario", $nombre, time() - 3600);
        unset($_COOKIE['nombre_usuario']);

        header("Location: cookies.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <!--Mostrar Usuario -->
    <!-- pongo mi etiqueta php con el codicinal correspondiente  -->
    <!-- muestro una etiqueta p con el nombre del usuario -->
    <!-- muestro el enlace olvidarme -->

    <!-- Mostrar Formulario -->
    <!-- etiqueta php cierro condiciona y pongo else -->
    <!-- muestro el formulario con input y boton -->
    <!-- cierro el else -->

</body>
</html>

<!-- 
    mensaje bienvendio a la pagina y un boton de zona admin para crear una sesion 
    (ya se por get o por post) donde se le va a poner la hora en la que se ha registrado, 
    se cogera el $_SESSION se le dara una clave/valor = date('H:i:s'); 
 -->
