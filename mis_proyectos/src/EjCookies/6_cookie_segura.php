<?php
// 6_cookie_segura.php
header("Content-Type: text/html; charset=UTF-8");

$valor = bin2hex(random_bytes(16));

setcookie("sesion_demo", $valor, [
    'expires' => time() + 3600,
    'path' => '/',
    'httponly' => true,     // No accesible desde JavaScript
    'secure' => TRUE,    // Cambiar a true si pruebas con HTTPS
    'samesite' => 'Strict'  // No se envía en peticiones cross-site
]);

echo "<h1>Cookie segura creada</h1>";
echo "<p>Valor generado: <code>" . htmlspecialchars($valor) . "</code></p>";

echo "<h2>Atributos aplicados</h2>";
echo "<ul>";
echo "<li><strong>HttpOnly:</strong> bloquea el acceso desde JavaScript (defensa contra XSS).</li>";
echo "<li><strong>Secure:</strong> solo se envía por HTTPS (en local con HTTP no se envía).</li>";
echo "<li><strong>SameSite=Strict:</strong> no se envía en peticiones desde otros sitios (defensa contra CSRF).</li>";
echo "</ul>";

echo "<h2>Prueba con JavaScript</h2>";
echo "<p>Pulsa el botón: si HttpOnly funciona, NO verás <code>sesion_demo</code>.</p>";
echo "<button onclick=\"document.getElementById('salida').textContent = 'document.cookie = ' + document.cookie;\">Leer document.cookie</button>";
echo "<pre id='salida'></pre>";
?>