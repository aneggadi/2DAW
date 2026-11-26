<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        foreach($_POST as $dato => $resultado){
            $_SESSION['datos'][$dato] =  $resultado;
        }
        header('Location:Anwar_Neggadi_Bouhdid_examen_RA3_RA4.php');
        exit;
    }

    if (isset($_GET['verificar']) && $_GET['verificar']){
        $_SESSION = [];
        session_destroy();

        header('Location:Anwar_Neggadi_Bouhdid_examen_RA3_RA4.php');
        exit;    
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Examen_Anwar_Neggadi</title>
</head>
<!-- Comprueba si existen los datos dentro de la sesion si no existen muestra el formulario -->
<body> <?php if(!isset($_SESSION['datos'])){ ?> 
    <div class="contenedor">
        <h1>Registrar Cliente</h1>
        <form action="" method = "POST">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name = "Nombre" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name = "Apellidos" required>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name = "DNI" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name = "Telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name = "Email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name = "Contraseña" required>

            <label for="password_confirm">Confirmar Password:</label>
            <input type="password" id="password_confirm" required>

            <button type = "Submit">Registrarse</button> 
        </form>
    </div>
    <!-- si existen los datos (se han enviado los datos muestra verificar los clientes) -->
    <?php }else{ ?>


    <div class="contenedor-two">
        <h1 class="title-two">Verificar Cliente</h1>

        <label class="label-two" for="nombre"><?php foreach($_SESSION['datos'] as $dato => $valor){  echo "<p> $dato => $valor  </p>"; }?></label>

        <a href = "Anwar_Neggadi_Bouhdid_examen_RA3_RA4.php?verificar=1" class="button-two">Verificar</a>
    </div>
    <?php } ?>

</body>

</html>