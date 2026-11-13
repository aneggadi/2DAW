<?php
session_start();
if (!isset($_SESSION['usuario'])) {
header('Location: login.php');
exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Panel</title></head>
<body>
<h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
<p>Esta zona es privada.</p>
<a href="logout.php">Cerrar sesión</a>
</body>
</html>