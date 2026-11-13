<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nameForm = $_POST['user'] ?? '';
        $passForm = $_POST['password'] ?? '';

        //usamos el htmlspecualchars para evitar que nos intruduzcan codigo html
        echo "Bienvenido al aula virtual: ". htmlspecialchars($nameForm) . PHP_EOL;
        echo " Tu contraseña es: " . htmlspecialchars($passForm) . PHP_EOL;
    }else echo "Entra al aula virtual desde el formulario";
?>