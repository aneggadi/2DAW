<?php
// 5_exportar.php
// Generamos un CSV y forzamos su descarga
// 1) Cabeceras de respuesta
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"notas.csv\"");
header("Cache-Control: no-cache");
// 2) Datos
$alumnos = [
["id" => 1, "nombre" => "Ana", "nota" => 7],
["id" => 2, "nombre" => "Luis", "nota" => 4],
["id" => 3, "nombre" => "Marta", "nota" => 9],
["id" => 4, "nombre" => "Pedro", "nota" => 5],
["id" => 5, "nombre" => "Sofía", "nota" => 8],
];
// 3) Escribimos al flujo de salida
$salida = fopen("php://output", "w");
// Cabecera del CSV
fputcsv($salida, ["id", "nombre", "nota"]);
// Filas
foreach ($alumnos as $alumno) {
fputcsv($salida, $alumno);
}
fclose($salida);
?>