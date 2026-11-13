<?php
// 1_info.php
// Mostramos todas las cabeceras de la solicitud (request)
header("Content-Type: text/html; charset=UTF-8");
$headers = getallheaders();
echo "<h1>Cabeceras de la solicitud</h1>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><th>Cabecera</th><th>Valor</th></tr>";
foreach ($headers as $nombre => $valor) {
echo "<tr>";
echo "<td><strong>" . htmlspecialchars($nombre) . "</strong></td>";
echo "<td>" . htmlspecialchars($valor) . "</td>";
echo "</tr>";
}
echo "</table>";
echo "<p>Total de cabeceras: " . count($headers) . "</p>";
?>