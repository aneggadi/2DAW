<?php
$conn = new mysqli("db", "usuario", "password", "mi_base_datos");

if ($conn->connect_error) {
    die("Fallo en la conexión MySQLi: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>