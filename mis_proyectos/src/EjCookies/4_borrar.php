<?php
// 4_borrar.php
if (isset($_COOKIE['nombre'])) {
    header("Content-Type: text/html; charset=UTF-8");
    // 1) Expiración en el pasado
    setcookie("nombre", "", time() - 3600);
    // 2) Eliminarla también de $_COOKIE en esta misma petición
    unset($_COOKIE['nombre']);

    echo "<p>Cookie 'nombre' <strong>eliminada</strong>.</p>";
} else {
    echo "<p>No hay cookie 'nombre' que borrar.</p>";
}


echo "<h1>Borrar cookie</h1>";


echo "<p><a href='1_cookie_basica.php'>Ir al ejercicio 1</a></p>";
?>
