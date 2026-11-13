<?php
session_start();
if (!isset($_SESSION['visitas'])) {
$_SESSION['visitas'] = 0;
}
$_SESSION['visitas']++;
echo "<h1>Has visitado esta página {$_SESSION['visitas']} veces</h1>";
echo "<p>ID de sesión: " . session_id() . "</p>";
echo '<a href="contador.php">Recargar</a> | ';
echo '<a href="reset.php">Resetear contador</a>';
?>