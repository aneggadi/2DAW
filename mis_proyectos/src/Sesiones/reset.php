<?php
session_start();
$_SESSION['visitas'] = 0;
header('Location: contador.php');
exit;
?>