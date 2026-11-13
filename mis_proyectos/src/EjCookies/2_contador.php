<?php
// Reset opcional
if (isset($_GET['reset'])) {
    setcookie("visitas", "", time() - 3600);
    unset($_COOKIE['visitas']);
    header("Location: 2_contador.php");
    exit;
}
// 2_contador.php
header("Content-Type: text/html; charset=UTF-8");

$visitas = isset($_COOKIE['visitas']) ? (int) $_COOKIE['visitas'] : 0;
$visitas++;

// 30 días de duración
setcookie("visitas", $visitas, time() + 60 * 60 * 24 * 30);

echo "<h1>Contador de visitas</h1>";

if ($visitas === 1) {
    echo "<p>Bienvenido, es tu primera visita.</p>";
} else {
    echo "<p>Has visitado esta página <strong>$visitas</strong> veces.</p>";
}

echo "<p><em>Recarga la página para incrementar el contador.</em></p>";
echo "<p><a href='2_contador.php?reset=1'>Resetear contador</a></p>";

?>