<?php
session_start();
$_SESSION['flash'] = 'Datos guardados correctamente ✅';
header('Location: ver.php');
exit;
?>