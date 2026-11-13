<?php 
echo "Ejercicio 1 <br>";
$pais = "España";
$habitantes = 47;
$capital = "Madrid";

echo "$pais tiene $habitantes y su capital es $capital <br>";

echo "<br> Ejercicio 2 <br>";

$entero = 10;
$float = 1.5;
$booleano = TRUE;
$string = "STRING";

echo "El numero entero es : ";
var_dump($entero);
echo "<br>";

echo "El Float es: ";
var_dump($float);
echo "<br>";

echo "El Boolean es: ";
var_dump($booleano);
echo "<br>";

echo "El String es: ";
var_dump($string);
echo "<br>";

echo "<br> Ejercicio 3 <br>";

$x = 28; $y = 6;

$suma = $x + $y;
$resta = $x - $y;
$multiplicacion = $x * $y;
$division = $x / $y;
$resto = $x % $y;
$potencia = $x ** $y;

echo "La suma de $x (x) y $y (y) es: $suma <br>";
echo "La resta de $x (x) y $y (y) es: $resta <br>";
echo "La multiplicacion de $x (x) y $y (y) es: $multiplicacion <br>";
echo "La division de $x (x) y $y (y) es: $division <br>";
echo "El resto de $x (x) y $y (y) es: $resto <br>";
echo "La potencia de $x (x) y $y (y) es: $potencia <br>";

echo "<br> Ejercicio 4 <br>";

$temperatura = 120;
if ($temperatura < -10){
    echo "Temperatura fuera de rango <br>";
}elseif ($temperatura < 5){
    echo "Hace mucho frío <br>";
}elseif($temperatura <= 15){
    echo "Hace fresco <br>" ;
}elseif($temperatura <= 25){
    echo "Temperatura agradable <br>";    
}elseif($temperatura <= 35){
    echo "Hace calor <br>";
}elseif ($temperatura > 35 and $temperatura < 50){
        echo "¡Hace un calor extremo! <br>" ;
}elseif($temperatura > 50){
    echo "Temperatura fuera de rango <br>";   
}
else echo "Temperatura incorrecta <br>";


echo "<br> Ejercicio 5 <br>";

$peliculas = ["Avengers","12 Hombres sin piedad","Hercules"];

print_r($peliculas);   
echo "<br>";
echo "La primera pelicula es: " . $peliculas[0] . "<br>";
echo "La ultima pelicula es: " . $peliculas[count($peliculas) - 1] . "<br>";
echo "Las peliculas totales son: " . count($peliculas) . "<br>";

echo "<br> Ejercicio 6 <br>";

$libro = ["titulo" => "Doraemon", "autor" => "Nobita", "anio" => "2005", "genero" => "drama/realista"];

echo "El titulo del libro es: " . $libro["titulo"] . "<br>";
echo "El autor del libro es: " . $libro["autor"] . "<br>";
echo "El año del libro es: " . $libro["anio"] . "<br>";
echo "El genero del libro es: " . $libro["genero"] . "<br>";

echo "<br> Ejercicio 7 <br>";

$animales = ["perro", "gato"];

echo "Los animales son : <br>";
print_r($animales);
echo "<br>";

array_push( $animales, "conejo");
echo "Los animales despues de añadir conejo son: <br>";
print_r($animales);
echo "<br>";

array_unshift($animales, "caballo");
echo "Los animales despues de añadir caballo al inicioo son: <br>";
print_r($animales);
echo "<br>";

array_pop($animales);
echo "Los animales despues de borrar el ultimo animal son: <br>";
print_r($animales);
echo "<br>";


echo "<br> Ejercicio 8 <br>";

$notas = [7, 3, 9, 5, 10, 2];   

sort($notas);
echo "Las notas ordenadas son de menor a mayor: <br>";
print_r($notas);
echo "<br>";

echo "Las notas ordenadas son de mayor a menor: <br>";
print_r(array_reverse($notas));
echo "<br>";

echo "La nota mas alta: " . max($notas);
echo "<br>";

echo "La nota mas baja: ". min($notas);
echo "<br>";

echo "La sumas de las notas es: " . array_sum($notas);
echo "<br>";

$promedio = array_sum($notas) / count($notas);
echo "El promedio de las notas es: $promedio";
echo "<br>";


echo "<br> Ejercicio 9 <br>";
$invitados = ["Carlos", "Lucía", "Andrés", "Sofía"];

if (in_array("Lucía", $invitados)){
    echo "Lucía ha confirmado su asistencia <br>";
}else echo "Lucía no ha confirmado <br>";

echo "<br> Ejercicio 10 <br>";

$contraseña = "12345AB@";

if (preg_match("/^[0-9]{5}[A-Z]{2}@$/", $contraseña)){
    echo "Contraseña correcta";
}else echo "Contraseña Incorrecta";



?>