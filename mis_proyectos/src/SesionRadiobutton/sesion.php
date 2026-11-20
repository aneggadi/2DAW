<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['radio'])) {
    $producto = trim($_POST['producto']);

    if ($producto !== '') {
        if (isset($_SESSION['carrito'][$producto])) {
            $_SESSION['carrito'][$producto]++;
        } else {
            $_SESSION['carrito'][$producto] = 1;
        }

        header('Location: sesion.php');
        exit;
    }
}

if (isset($_GET['borrar']) && $_GET['borrar'] == '1') {
    $_SESSION['carrito'] = [];

    header('Location: sesion.php');
    exit;
}

if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    $_SESSION = [];
    session_destroy();

    header('Location: sesion.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>
<body>
    <h1>Carrito</h1>

    <form action="" method="POST">
        <input type="text" name="producto">
        <button type="submit">Añadir</button>
        <input type="radio" name="radio" id="radio1" value = 1>1
        <input type="radio" name="radio" id="radio2" value = 2>2
        <input type="radio" name="radio" id="radio3" value = 3>3
    </form>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>Carrito vacío</p>
    <?php else: ?>
        <ul>
            <?php
            $total = 0;

            foreach ($_SESSION['carrito'] as $producto => $cantidad) {
                $total += $cantidad;
                echo '<li>' . htmlspecialchars($producto) . ' x ' . $cantidad . '</li>';
            }
            ?>
        </ul>
        <p>Total de unidades: <?php echo $total; ?></p>
    <?php endif; ?>

    <p>
        <a href="sesion.php?borrar=1">Vaciar carrito</a>
        |
        <a href="sesion.php?logout=1">Cerrar sesión</a>
    </p>
</body>
</html>