<?php 
$_visitas = 0
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_COOKIE['numero_veces'])){
        setcookie('numero_veces', $numero, time()+(86400*2), '/');
        header('Location: Contador.php')
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<!-- contador que cada vez que refresquemos la pagina aumente -->
