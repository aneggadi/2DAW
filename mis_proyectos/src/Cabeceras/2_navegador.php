<?php
// 2_navegador.php
// Detectamos el navegador a partir del User-Agent
header("Content-Type: text/html; charset=UTF-8");
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';
// IMPORTANTE: comprobar Edge antes que Chrome,
// porque el UA de Edge también contiene "Chrome".
if (stripos($ua, 'Edg') !== false) {
$navegador = "Microsoft Edge";
} elseif (stripos($ua, 'Firefox') !== false) {
$navegador = "Mozilla Firefox";
} elseif (stripos($ua, 'Chrome') !== false) {
$navegador = "Google Chrome";
} elseif (stripos($ua, 'Safari') !== false) {
$navegador = "Safari";
} else {
$navegador = "Navegador desconocido";
}
if (stripos($ua, "Win")){
    $sistema_operativo = "windows";
}elseif (stripos($ua, "Lin")){
    $sistema_operativo = "Linux";
}elseif (stripos($ua, "Mac")) {
    $sistema_operativo = "Mac";
}
echo "<h1>Tu navegador</h1>";
echo "<p>Estás usando: <strong>" . htmlspecialchars($navegador) .
"</strong></p>";
echo "<p>User-Agent completo:</p>";
echo "<pre>" . htmlspecialchars($ua) . "</pre>";
echo "<p>Estás usando: <strong>" . htmlspecialchars($sistema_operativo);    

?>