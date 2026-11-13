<?php
// 7_reset.php
header("Content-Type: text/html; charset=UTF-8");

setcookie("tema", "", time() - 3600, '/');
unset($_COOKIE['tema']);

header("Location: 7_tema.php");
exit;
?>