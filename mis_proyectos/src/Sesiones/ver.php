<?php
session_start();
if (isset($_SESSION['flash'])) {
$msg = $_SESSION['flash'];
unset($_SESSION['flash']); // se borra al mostrarlo
} else {
$msg = 'No hay mensajes nuevos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Flash</title></head>
<body>
<p><?= htmlspecialchars($msg) ?></p>
<a href="ver.php">Recargar (ya no verás el flash)</a><br>
<a href="guardar.php">Generar flash</a>
</body>
</html>