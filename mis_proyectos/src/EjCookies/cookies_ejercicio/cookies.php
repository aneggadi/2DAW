<?php
// Crear cookie
if($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['nombre'])) {
    $nombre = trim($_POST['nombre']);
    setcookie('nombre_usuario', $nombre, time()+(86400*2), '/');

    header('Location: cookies.php');
    exit;
}

// Borrar cookie
if ($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['olvidar'])){
    if (isset($_COOKIE['nombre_usuario'])) {
        setcookie('nombre_usuario', '', time()-3600, '/');
        unset($_COOKIE['nombre_usuario']);

        header('Location: cookies.php');
        exit;  
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
 <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      background-color: #121212;
      color: #ffffff;
    }

    .formulario-contenedor {
      background: #1e1e1e;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
      border: 1px solid #2c2c2c;
      width: 100%;
      max-width: 400px;
    }

    .formulario-grupo {
      display: flex;
      gap: 10px;
    }

    input[type="text"] {
      flex: 1;
      padding: 12px 15px;
      background-color: #2a2a2a;
      color: #ffffff;
      border: 1px solid #3f3f3f;
      border-radius: 6px;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s ease;
    }

    input[type="text"]::placeholder {
      color: #888888;
    }

    input[type="text"]:focus {
      border-color: #4dabf7;
    }

    button {
      padding: 12px 20px;
      background-color: #3b82f6;
      color: #ffffff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2563eb;
    }

    p {
      font-size: 32px;
      margin: 10px;
    }

    a {
      text-decoration: none;
      color: red;
      font-size: 32px;
      cursor: pointer;
    }
  </style>
<body>


 <?php if (isset($_COOKIE['nombre_usuario'])) { ?>


<p> Hola <?= $_COOKIE['nombre_usuario'] ?></p>
<a href="?olvidar=1">Olvidarme</a>

<?php } else { ?>

   <div class="formulario-contenedor">
    <form class="formulario-grupo" action="#" method="POST">
      <input type="text" name="nombre" placeholder="Escribe algo aquí..." autocomplete='off' required>
      <button type="submit">Enviar</button>
    </form>
  </div>

 <?php } ?>

</body>
</html>

<!-- contador que cada vez que refresquemos la pagina aumente -->