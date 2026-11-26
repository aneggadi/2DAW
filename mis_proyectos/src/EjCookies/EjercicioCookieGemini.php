<?php 
    header("Content-Type: text/html; charset= UTF-8");

    if (isset($_GET['reset'])) {
        setcookie("usuario_alias", "", time() - 3600, '/');
        setcookie("usuario_color", "", time() - 3600, '/');
        setcookie("visitas", "", time() - 3600, '/');
        header('Location: EjercicioCookieGemini.php');
        exit;
    }
    $expiracion = time() + (3600 * 24 * 15);
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['alias']))){
        setcookie("usuario_alias",trim($_POST['alias']), $expiracion, '/', '',false, true);
        setcookie("usuario_color", $_POST['color'], $expiracion, '/', '', false, true);
        
        header('Location:EjercicioCookieGemini.php');
        exit;
    }

    if (!isset($_COOKIE['visitas'])){
        $visitas = 1;
    }else{
        $visitas = (int)$_COOKIE['visitas'] + 1;
    }
    setcookie("visitas", $visitas, $expiracion, '/', '', false, true);
    $color = $_COOKIE['usuario_color'] ?? '#ffffff';
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        background-color: <?= $color ?>
    }
</style>
<body>
    <form action="" method = "post">
        <input type="text" name="alias" id="alias">
        <select name="color" id="color">
            <option value="#ffffff" <?= ($color === '#ffffff') ? 'selected' : '' ?>>Blanco</option>
            <option value="#fdf6e3" <?= ($color === '#fdf6e3') ? 'selected' : '' ?>>Crema</option>
            <option value="#e2e8f0" <?= ($color === '#e2e8f0') ? 'selected' : '' ?>>Gris</option>
        </select>
        <button type="submit">Enviar Seleccion</button>
        <a href="EjercicioCookieGemini.php?reset=1">Resetear</a>
    </form>

    <?php if (isset($_COOKIE['usuario_alias']) && isset($_COOKIE['usuario_color'])): ?>
        <h2>Hola, <?= htmlspecialchars($_COOKIE['usuario_alias']) ?>. Has visitado esta página <?= $visitas ?> veces.</h2>
    <?php else: ?>
        <h2>Configura tus preferencias de lectura</h2>
    <?php endif; ?>
</body>
</html>