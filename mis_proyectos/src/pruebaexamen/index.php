<?php

echo "Ejercicio 1 <br>";
$nombre = "Anwar";
$edad = 20;
$ciudad = "Madrid";
echo "Me llamo " . $nombre . ", tengo " . $edad . " años y vivo en " . $ciudad;

echo "<br> Ejercicio 2 <br>";
$entero = 10;
$decimal = 10.5;
$booleano = FALSE;
$string = "Cadena";

echo "La variable entera es: ";
var_dump($entero);
echo "<br> La variable decimal es: ";
var_dump($decimal);
echo "<br> La variable booleana es: ";
var_dump($booleano);
echo "<br> La variable string es: ";
var_dump($string);

echo "<br> Ejercicio 3 <br>";
$a = 15;
$b = 4;

$suma = $a + $b;
$resta = $a - $b;
$multiplicacion = $a * $b;
$division = $a / $b;
$resto = $a % $b;

echo "a = $a, b = $b <br> La suma de a y b es: $suma <br> La resta de a y b es: $resta <br> La multiplicacion de a y b es: $multiplicacion
<br> La division de a y b es: $division <br> El resto de a entre b es: $resto"; 

echo "<br> Ejercicio 4 <br>";
$nota = 10;

if ($nota < 0){
    echo "No se admiten notas negativas";
}elseif ($nota < 5){
    echo "Suspenso";
}elseif ($nota < 7){
    echo "Aprobado";
}elseif ($nota < 9){
    echo "Notable";
}elseif ($nota <= 10){
    echo "Sobresaliente";
}else echo "Nota incorrecta";

echo "<br> Ejercicio 5 <br>";

$colores = ["Rojo","Amarillo","Verde"];

print_r($colores);

echo "<br> Primer color del array: $colores[0]";

echo "<br> Ultimo color del array: $colores[2]";

echo "<br> Cantidad de colores en el array: " . count($colores);

echo "<br> Ejercicio 6 <br>";

$array_asociativo = ["Nombre" => "Anwar", "Apellido" => "Neggadi", "Edad" => "20", "correo" => "aneggadibouhdid@educa.madrid.org"];

echo "EL nombre en el array es: " . $array_asociativo["Nombre"] . "<br>";
echo "EL apellido en el array es: ".  $array_asociativo["Apellido"] . "<br>";
echo "La edad en el array es: " . $array_asociativo["Edad"] . "<br>";
echo "EL correo en el array es: " . $array_asociativo["correo"] . "<br>";

echo "<br> Ejercicio 7 <br>";

$frutas = ["manzana", "pera"];

array_push($frutas, "platano");
echo "Añadimos platano: <br>";
print_r($frutas);
unset($frutas[count($frutas) - 1]);
echo "<br> Eliminamos la ultima posicion: <br>";
print_r($frutas);

echo "<br> 8 <br>";
$numeros = [5, 2, 8, 1, 9, 3];

sort($numeros);

echo "El array ordenado de mayor a menor es: " ;
print_r($numeros);
echo "<br>";
echo "El array ordenado de menor a mayor es: ";
print_r(array_reverse($numeros));
echo "<br>";

$numero_mayor = $numeros[0];
$numero_menor = $numeros[0];

echo "Forma larga: ";
foreach ($numeros as $val){
    if ($val > $numero_mayor){
        $numero_mayor = $val;
    }
    if ($val < $numero_menor){
        $numero_menor = $val;
    }
}


echo "<br> El numero mayor es: $numero_mayor <br> El numero menor es: $numero_menor <br>";

echo "Forma corta: <br> Como ya tenemos ordenado los numeros de menor a mayor solo necesitamos coger el primer numero como es el menor y el ultimo el mayor";

echo "<br> El numero mayor es: ". $numeros[count($numeros)-1] . "<br> El numero menor es: " . $numeros[0] ;

echo "<br> Ejercicio 9 <br>";
$alumnos = ["Ana", "Luis", "Marta", "Pedro"];

if (array_search("Marta", $alumnos)){
    echo "Marta está en clase";
}else echo "Marta no está en clase";

$telefono_aleman =  '+49 171 1234567';
if (preg_match("/^\+49 [0-9]{3} [0-9]{7}$/", $telefono_aleman)){
    echo "<br> Numero de telefono correcto";
}else echo " <br> Numero de telefono incorrecto";
?>