<?php
// 3_expiracion.php
header("Content-Type: text/html; charset=UTF-8");

$expiracion = time() + 60 * 60 * 24 * 7; // 7 días
$ahora = date("Y-m-d H:i:s");

// Creamos/actualizamos la cookie
setcookie("ultima_visita", $ahora, $expiracion);

echo "<h1>Última visita y expiración</h1>";

if (isset($_COOKIE['ultima_visita'])) {
    echo "<p>Tu última visita fue: <strong>" . htmlspecialchars($_COOKIE['ultima_visita']) . "</strong></p>";
} else {
    echo "<p>No había visita previa registrada.</p>";
}

echo "<p>Visita actual registrada: <strong>$ahora</strong></p>";
echo "<p>Esta cookie expirará el: <strong>" . date("Y-m-d H:i:s", $expiracion) . "</strong></p>";
echo "<p><em>Recarga para ver cómo cambia.</em></p>";
?>