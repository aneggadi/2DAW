<?php

// 1_cookie_basica.php
header("Content-Type: text/html; charset=UTF-8");

if (!isset($_COOKIE['nombre'])) {
    // No existe: la creamos (1 hora de duración)
    setcookie("nombre", "Ana", time() + 3600);
    echo "<h1>Cookie creada</h1>";
    echo "<p>Se ha creado la cookie 'nombre' con valor 'Ana'.</p>";
    echo "<p><strong>Recarga la página</strong> para verla.</p>";
} else {
    // Existe: mostramos su valor
    echo "<h1>Cookie encontrada</h1>";
    echo "<p>Valor de 'nombre': <strong>" . htmlspecialchars($_COOKIE['nombre']) . "</strong></p>";
    echo "<p><a href='4_borrar.php'>Borrar la cookie</a></p>";
}
?>
