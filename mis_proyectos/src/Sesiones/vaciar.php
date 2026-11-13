<?php
session_start();
unset($_SESSION['carrito']);
header('Location: tienda.php');
exit;
?>