<?php
session_start();
if (isset($_GET['tema'])) {
$_SESSION['tema'] = in_array($_GET['tema'], ['claro', 'oscuro']) ?
$_GET['tema'] : 'claro';
header('Location: preferencias.php');
exit;
}
$tema = $_SESSION['tema'] ?? 'claro';
$bg = $tema === 'oscuro' ? '#111' : '#fff';
$fg = $tema === 'oscuro' ? '#eee' : '#111';
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Preferencias</title></head>
<body style="background:<?= $bg ?>;color:<?= $fg
?>;font-family:sans-serif">
<h1>Tema actual: <?= $tema ?></h1>
<a href="?tema=claro">Claro</a> | <a href="?tema=oscuro">Oscuro</a>
</body>
</html>