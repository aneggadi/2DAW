<?php
    session_start();

    if (!isset($_SESSION['carrito'])){
        $_SESSION['carrito'] = [];
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])){
        $producto = $_POST['producto_id'];

        if (isset($_SESSION['carrito'][$producto])){
            $_SESSION['carrito'][$producto]++;    
        }else {
            $_SESSION['carrito'][$producto] = 1; 
        }
        header('Location:carrito_Examen.php');
        exit;
    }


?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Añadir al carrito</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Contenedor de los productos en formato Grid */
        .contenedor-productos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Tarjeta de cada producto */
        .producto {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .producto img {
            width: 100%;
            height: 150px;
            object-fit: cover; /* Para que la imagen no se deforme */
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .producto h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .producto .precio {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        /* Botón de añadir */
        .btn-carrito {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }

        .btn-carrito:hover {
            background-color: #2980b9;
        }

        /* Botón para ver el carrito */
        .btn-ver-carrito {
            display: block;
            width: 200px;
            margin: 40px auto 0;
            background-color: #2ecc71;
            text-align: center;
            padding: 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-ver-carrito:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <h1>Nuestra Tienda</h1>

    

        <!-- Producto 1 -->
        <form action="" class="contenedor-productos" method = 'POST'>
        <div class="producto">
            <img src="https://picsum.photos/seed/p1/300/200" alt="Producto 1">
            <h2>Teclado Mecánico</h2>
            <p class="precio">45.99 €</p>
            <!-- Los alumnos tendrán que hacer que este botón envíe el ID del producto -->
                <button class="btn-carrito" type = "submit" name="producto_id" value="Teclado Mecanico">Añadir al carrito</button>
            </div>
        </form>

        <!-- Producto 2 -->
        <form action="" class="contenedor-productos" method = 'POST'>
        <div class="producto">
            <img src="https://picsum.photos/seed/p2/300/200" alt="Producto 2">
            <h2>Ratón Inalámbrico</h2>
            <p class="precio">25.50 €</p>
                <button class="btn-carrito" type = "submit" name="producto_id" value="Raton Inalambrico">Añadir al carrito</button>
            </div>
        </form>

        <!-- Producto 3 -->
        <form action="" class="contenedor-productos" method = 'POST'>
        <div class="producto">
            <img src="https://picsum.photos/seed/p3/300/200" alt="Producto 3">
            <h2>Monitor 24"</h2>
            <p class="precio">150.00 €</p>
                <button class="btn-carrito" type = "submit" name="producto_id" value="Monitor 24">Añadir al carrito</button>
            </div>
        </form>

        <!-- Producto 4 -->
        <form action="" class="contenedor-productos" method = 'POST'>
        <div class="producto">
            <img src="https://picsum.photos/seed/p4/300/200" alt="Producto 4">
            <h2>Auriculares Gaming</h2>
            <p class="precio">35.90 €</p>
                <button class="btn-carrito" type = "submit" name="producto_id" value="">Añadir al carrito</button>
            </div>
        </form>

        <!-- Producto 5 -->
        <form action="" class="contenedor-productos" method = 'POST'>
        <div class="producto">
            <img src="https://picsum.photos/seed/p5/300/200" alt="Producto 5">
            <h2>Alfombrilla XL</h2>
            <p class="precio">15.00 €</p>
                <button class="btn-carrito" type = "submit" name="producto_id" value="5">Añadir al carrito</button>
            </div>
        </form>

        <!-- Producto 6 -->
        <form action="" class="contenedor-productos" method = 'POST'>
        <div class="producto">
            <img src="https://picsum.photos/seed/p6/300/200" alt="Producto 6">
            <h2>Webcam Full HD</h2>
            <p class="precio">49.99 €</p>
                <button class="btn-carrito" type = "submit" name="producto_id" value="6">Añadir al carrito</button>
            </div>
        </form>


    <!-- Botón/enlace de ejemplo para que los alumnos programen a dónde va -->
    <?php if(!$_GET['vercarrito']){ ?>
        <a href="carrito_Examen.php?vercarrito=1" class="btn-ver-carrito">Ver mi carrito</a>
        
    <?php } else{
        foreach($_SESSION['carrito'] as $producto => $cantidad){
            echo '<li>' . htmlspecialchars($producto) . ' x ' . $cantidad . '</li>';
        }
    }
    ?>
    <a href="carrito_Examen.php?borrar=1" class="btn-ver-carrito">Borrar Carrito </a>

</body>
</html>