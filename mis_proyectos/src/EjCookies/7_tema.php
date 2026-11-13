<?php
// 7_tema.php
header("Content-Type: text/html; charset=UTF-8");

// Si llega ?tema=claro|oscuro, guardamos en cookie y redirigimos
if (isset($_GET['tema'])) {
    $tema = ($_GET['tema'] === 'oscuro') ? 'oscuro' : 'claro';
    setcookie("tema", $tema, time() + 60 * 60 * 24 * 365); // 1 año
    header("Location: 7_tema.php");
    exit;
}

$tema = $_COOKIE['tema'] ?? 'claro';
$fondo = ($tema === 'oscuro') ? '#222' : '#fff';
$texto = ($tema === 'oscuro') ? '#eee' : '#000';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tema preferido</title>
    <style>
        body {
            background-color: <?= $fondo ?>;
            color: <?= $texto ?>;
            font-family: sans-serif;
            padding: 2rem;
            transition: background 0.3s, color 0.3s;
        }

        a.button {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            background: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h1>Preferencia de tema</h1>
    <p>Tema actual: <strong>
            <?= htmlspecialchars($tema) ?>
        </strong></p>

    <p>
        <a class="button" href="7_tema.php?tema=claro">Tema claro</a>
        <a class="button" href="7_tema.php?tema=oscuro">Tema oscuro</a>
    </p>

    <p><a href="7_reset.php" style="color:#e74c3c;">Resetear preferencia</a></p>
</body>

</html>