<?php
// 5_leer_cookie.php
header("Content-Type: text/html; charset=UTF-8");

echo "<h1>Leer cookie 'seccion'</h1>";
echo "<p>Ruta actual: <code>" . htmlspecialchars($_SERVER['REQUEST_URI']) . "</code></p>";

if (isset($_COOKIE['seccion'])) {
    echo "<p>Cookie encontrada: <strong>" . htmlspecialchars($_COOKIE['seccion']) . "</strong></p>";
} else {
    echo "<p>La cookie NO está disponible en esta ruta.</p>";
}

echo "<p><a href='5_set_cookie.php'>Volver</a></p>";
?>
