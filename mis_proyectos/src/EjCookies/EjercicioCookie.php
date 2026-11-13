que una cookie guarde el nombre del usuario, que luego lo muestre y que este la opcion de borrar el nombre de ususario (borrar la cookie)
<?php 
    //CREAR COOKIE
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])){
        $nombre = trim($_POST['nomre']);
        setcookie('nombre_usuario', $nombre, time()+(86400 * 2), "/");

        header('Location: cookies.php');
        exit;
    }
    //BORRAR COOKIE
    if(isset($_COOKIE['nombre_usuario'])){
        setcookie("nombre_usuario", $nombre, time() - 3600);
        unset($_COOKIE['nombre_usuario']);
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

    <!-- Mostrar Formulario -->
</body>
</html>