<?php
// 5_set_cookie.php
header("Content-Type: text/html; charset=UTF-8");

setcookie("seccion", "admin", [
    'expires' => time() + 3600,
    'path' => 'EjCookies/admin/',   // Solo se enviará bajo /admin/
    'httponly' => true,
    'samesite' => 'Lax'
]);

echo "<h1>Cookie 'seccion' creada</h1>";
echo "<p>Valor: <strong>admin</strong></p>";
echo "<p>Ámbito: <code>/admin/</code></p>";
echo "<p>Prueba ahora:</p>";
echo "<ul>";
echo "<li><a href='5_leer_cookie.php'>/5_leer_cookie.php</a> → NO debería verla</li>";
echo "<li><a href='admin/5_leer_cookie.php'>/admin/5_leer_cookie.php</a> → SÍ debería verla</li>";
echo "</ul>";
?>
