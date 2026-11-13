<?php 
    /*Ejercicio 1: Lista de nombres
    Crea un array con 5 nombres y muéstralos en una lista HTML <ul>.
    Pista: Usa foreach. */
    $nombres = array("Juan", "María", "Pedro", "Ana", "Luis");
    echo "1. <ul>";
    foreach ($nombres as $nombre) {
        echo "<li>$nombre</li>";
    }
    echo "</ul>";

    /*Ejercicio 2: Números y suma
    Crea un array con los números [4, 8, 15, 16, 23, 42] y muestra:
    ● Todos los números.
    ● La suma total.
    ● El número mayor.
    ● El número menor.
    Pista: Usa array_sum(), max(), min() */

    $numeros = [4, 8, 15, 16, 23, 42];
    $may = $numeros[0];
    $menor = $numeros[0];
    echo "<br> 2. <br>";
    echo "Los numeros del array son: ";
    foreach ($numeros as $n) {
        echo "$n \n";
        if ($n > $may){
            $may = $n;
        }elseif ($n < $menor){
            $menor = $n;
        }
    }
    echo "<br> La suma de todos los arrays es: ". array_sum($numeros) . "<br>";
    echo "El numero mayor del array es: " . $may . "<br>";
    echo "El numero menor del array es: ". $menor . "<br>";
    echo "El mayor de todos es " . $may . "<br>";

    /*Ejercicio 3: Contar elementos
    Dado el array ["rojo", "verde", "azul", "amarillo"], muestra cuántos elementos tiene.
    Pista: count().*/
    
    $colores = ["rojo", "verde", "azul", "amarillo"];
    echo "<br> 3. <br> ";
    echo "La cantidad de valores en el array es de: ". count($colores) . "<br>";

    /*Ejercicio 4: Añadir y eliminar
    Partiendo del array ["manzana", "pera", "plátano"]:
    1. Añade "naranja" al final.
    2. Elimina "pera".
    3. Muestra el array resultante.
    Pista: array_push(), unset() o array_splice(). */

    echo "<br> 4.";
    $frutas = ["manzana", "pera", "plátano"];
    array_push($frutas, "naranja");
    $busqueda = array_search("pera", $frutas);
    unset($frutas[$busqueda]);
    echo " <br> Las frutas que hay son: ";  
    foreach($frutas as $val){
        echo "$val ";
    }
    echo "<br>";
   
    /*Ejercicio 5: Ordenar
    Crea un array con 6 números desordenados y muéstralos ordenados de menor a
    mayor y de mayor a menor.
    Pista: sort() y rsort(). */

    echo "<br> 5. ";
    $numeros = [1,7,3,46,8,2];
    echo " <br> Los numeros desordenados son: "; 
    foreach ($numeros as $val){
        echo $val . "\n";
    }
    sort($numeros);
     echo "<br> Los numeros ordenados son: "; 
    foreach ($numeros as $val){
        echo $val . "\n";
    }
    echo "<br>";

    /*Ejercicio 6: Ficha personal
    Crea un array asociativo con tus datos: nombre, edad, ciudad y profesión. Recórrelo
    y muestra cada dato con su clave.
    Ejemplo de salida:
    nombre: Ana
    edad: 25
    ciudad: Madrid
    profesion: Programadora */

    $datos = ["Nombre" => "Anwar",
            "Edad" => 20,
            "Ciudad" => "Madrid",
            "Profesion" => "Programador"];

    echo "<br> 6. <br>";

    foreach($datos as $clave => $valor){
    echo $clave . ': "' . $valor . '"<br>';
    }

    /*Ejercicio 7: Precios de productos
    Crea un array asociativo con 5 productos y sus precios:
    php
    $productos = [
     "Teclado" => 25.50,
     "Ratón" => 15.99,
     "Monitor" => 199.99,
     "Altavoces" => 45.00,
     "Webcam" => 30.75
    ];
    Muestra:
    ● Todos los productos con su precio.
    ● El producto más caro.
    ● El producto más barato.
    ● El precio total de todos los productos.
    Pista: Usa foreach, max(), min(), array_sum(). */

    $productos = [
     "Teclado" => 25.50,
     "Ratón" => 15.99,
     "Monitor" => 199.99,
     "Altavoces" => 45.00,
     "Webcam" => 30.75
    ];
    echo "<br> 7. <br>";
    foreach($productos as $clave => $valor){
        echo " El producto es: $clave, precio: $valor <br>";
    }
    
    echo "<br> El producto mas caro es: ". array_search(max($productos), $productos);
    echo "<br> El producto mas barato es: ". array_search(min($productos), $productos);
    echo "<br>La suma de los productos es: ". array_sum($productos);

    /*Ejercicio 8: Contar votos
    Dado este array:
    php
    $votos = ["Ana", "Luis", "Ana", "Marta", "Ana", "Luis", "Carlos", "Ana"];
    Muestra cuántos votos ha recibido cada candidato.
    Salida esperada:
    Ana: 4 votos
    Luis: 2 votos
    Marta: 1 voto
    Carlos: 1 voto
    Pista: Usa un array asociativo auxiliar y isset(). */

    $votos = ["Ana", "Luis", "Ana", "Marta", "Ana", "Luis", "Carlos", "Ana"];
    $cuenta = [];

    foreach($votos as $x){
        if(!isset($cuenta[$x])){
            $cuenta[$x] = 1;
        }else{
            $cuenta[$x]++;
        }
    }
    foreach($cuenta as $clave => $valor){
        echo "<br> $clave $valor";
    }

?>