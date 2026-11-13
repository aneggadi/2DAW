<?php 
    /*1. Crea dos variables $nombre y $apellido y muestra por pantalla el nombre completo separado por un espacio.
    */

    php.info();
    
    $nombre = "Diego";
    $apellido = "Gonzalez";

    echo '1. ' . $nombre . " " . $apellido . "<br>";
    
    /*2. Declara $edad = 25 y muestra la frase: Tengo 25 años.
    */
    
    $edad = 25;
    echo '2. '.'Tengo' . " " . $edad . " " . 'años.'. "<br>";

    /* 3. Crea tres variables $a = 5, $b = 10, $c = 15 y muestra sus valores separados por guiones: 5 - 10 - 15.
    */
 
    $a = 5;
    $b = 10;
    $c = 15;

    echo '3. '.$a . " - " . $b . " - " . $c . "<br>";

    /*4. Declara $precio = 19.99 y $unidades = 3. Muestra el mensaje: 3 unidades a 19.99 € cada una.
*/

    $precio = 19.99;
    $unidades = 3;

    echo '4. '.$unidades . " " . 'unidades a' . " " . $precio . " € cada una." . "<br>";

    /*5. Crea una variable $mensaje = "Hola" y otra $destino = "mundo". Muestra: Hola mundo usando concatenación con .. */

    $mensaje = "Hola";
    $destino = "mundo";

    echo '5. ' . $mensaje . " " . $destino . "<br>";

    /*6. Haz lo mismo que el ejercicio 5 pero usando interpolación de variables dentro de comillas dobles.*/
    $mensaje = "Hola";
    $destino = "mundo";

    echo "6. $mensaje $destino <br>";

    /*7. Declara $x = 8 e imprime su valor usando echo dos veces: una con comillas dobles y otra con comillas simples. Observa la diferencia.*/

    $x = 8;
    echo '7. ' . $x . "<br>";
    echo "7. $x <br>";

    /*8. Declara $a = 20 y $b = 6. Muestra el resultado de la suma, resta, multiplicación y división.
    */

    $a = 20;
    $b = 6;
    $suma = $a + $b;
    $resta = $a - $b;
    $multiplicacion = $a * $b;
    $division = $a / $b;

    echo "8. suma: $suma, resta: $resta, multiplicacion: $multiplicacion, division: $division <br>";

    /*9. Declara $a = 20 y $b = 6. Muestra el módulo (resto) y explica con un echo qué representa.
    */ 

    $a = 20;
    $b = 6;

    $resto = $a % $b;

    echo "9. El resto: $resto, representa la cantidad que resta de la division para completar el numero entero <br>";

    /* 10. Declara $base = 7 y $exponente = 3. Calcula la potencia usando ** y muestra el resultado.
    */

    $base = 7;
    $exponente = 3;

    $resultado = $base ** $exponente;

    echo "10. El resultado de la operacion es $resultado <br>";

    /*11. Calcula el área de un círculo con $radio = 4 y $pi = 3.1416. Fórmula: $pi * $radio ** 2.*/

    $radio = 4;
    $pi = 3.1416;

    $Formula = $pi * $radio ** 2;
    
    echo "11. El area del circulo es: $Formula <br>";

    /*12. Declara $precio = 250 y $descuento = 20 (porcentaje). Calcula y muestra el precio final.*/

    $precio = 250;
    $descuento = 20;

    $precio_final = $precio - ($precio * ($descuento / 100));
    echo "12. El precio final es: $precio_final <br> ";

    /*13. Declara $horas = 2, $minutos = 45 y $segundos = 30. Convierte todo a segundos y muestra el total.
    */

    $horas = 2;
    $minutos = 45;
    $segundos = 30;

    $segundos_totales = ($horas * 3600) + ($minutos * 60) + $segundos;

    echo "13. El total de segundos es: $segundos_totales <br>";

    /*14. Declara $total = 100 y $personas = 3. Muestra cuánto paga cada persona y cuánto sobra (usa división y módulo).
    */

    $total = 100;
    $personas = 3;

    $division = $total / $personas;
    $resto = $total % $personas;

    echo "14. Lo que paga cada persona es: $division, y sobra: $resto <br>";

    /* 15. Declara $contador = 10. Súmale 5 usando += y muestra el resultado.*/

    $contador = 10;

    $contador += 5;

    echo "15. El resultado es $contador <br>";

    /* 16. Declara $precio = 200. Aplícale un descuento del 15% usando -= y muestra el resultado.*/

    $precio = 200;

    $precio -= ($precio * 0.15);

    echo "16. El precio con descuento es: $precio <br>";

    /*17. Declara $numero = 4. Multiplícalo por sí mismo usando *= y muestra el resultado.*/

    $numer = 4;

    $numer *= $numer;

    echo "17. El resultado es: $numer <br>";

    /* 18. Declara $texto = "Programación" y muestra su longitud con strlen().*/

    $texto = "Programacion";
    $longitud = strlen($texto);
    echo "18. La longitud del texto ($texto) es de $longitud caracteres <br>";
    
    /*19. Declara $texto = "php" y muéstralo en mayúsculas con strtoupper() y en minúsculas con strtolower().*/

    $texto = "php";

    echo "19. El texto $texto en mayusculas es: " . strtoupper($texto) . "<br>";

    /*20. Declara $frase = " Hola mundo " y muestra la frase sin espacios al principio y al final con trim(). */

    $frase = "  Hola mundo  ";

    echo "20. El resultado de la frase $frase tras trim() es: " . trim($frase) . "<br>";


    /*21. Declara $nombre = "Carlos" y $apellido = "García". Une ambos con strtoupper() aplicado a los apellidos: Carlos GARCÍA. */

    $nombre = "Carlos";
    $apellido = "García";
    $nombre_completo = $nombre . " " . strtoupper($apellido);

    echo "21. El nombre completo es: $nombre_completo <br>";

    /*22. Crea una función sumar($a, $b) que devuelva la suma y pruébala con echo tres veces con valores distintos.
 */
    function sumar($a, $b) {
        return $a + $b;
    }

    echo "22. La suma de 5 y 3 es: " . sumar(5, 3) . "<br>";
    echo "22. La suma de 10 y 7 es: " . sumar(10, 7) . "<br>";
    echo "22. La suma de 2 y 8 es: " . sumar(2, 8) . "<br>";


    /*23. Crea una función calcularAreaRectangulo($base, $altura) que devuelva el área. Pruébala con dos pares de valores.*/
    function calcularAreaRectangulo($base, $altura) {
        return $base * $altura;
    }

    echo "23. El área del rectángulo con base 5 y altura 3 es: " . calcularAreaRectangulo(5, 3) . "<br>";
    echo "23. El área del rectángulo con base 10 y altura 7 es: " . calcularAreaRectangulo(10, 7) . "<br>";

    /*24. Crea una función aplicarIVA($precio, $iva = 21) que devuelva el precio con IVA. Pruébala con el IVA por defecto y con un IVA del 10%. */
    function aplicarIVA($precio, $iva = 21) {
        return $precio + ($precio * $iva / 100);
    }

    echo "24. El precio con IVA del 21% es: " . aplicarIVA(100) . "<br>";
    echo "24. El precio con IVA del 10% es: " . aplicarIVA(100, 10) . "<br>";

    /*25. Crea una función formatearPrecio($cantidad) que devuelva la cadena "El precio es X €". Pruébala con dos valores distintos.*/
    function formatearPrecio($cantidad) {
        return "El precio es $cantidad €";
    }

    echo "25. " . formatearPrecio(100) . "<br>";
    echo "25. " . formatearPrecio(50) . "<br>";


  /* 
    /*En sakila idetificar el actor que ha hecho mas peliculas, quien es y cuantas peluclas ha hecho 
    SELECT a.first_name,  count(*) FROM actor a 
    JOIN film_actor fa on a.actor_id = fa.actor_id
    GROUP by fa.actor_id
    order by 2 DESC;
    
    /*Listado de peliculas vencidas
    Select f.tite
  */

    /*Peliculas que nunca han sido alquiladas
    SELECT f.title FROM film f
    LEFT JOIN inventory i on f.film_id = i.film_id
    LEFT JOIN rental r on i.inventory_id = r.inventory_id
    WHERE r.rental_id IS NULL;

    */



?>
