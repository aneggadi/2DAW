<?php
$texto = "Tengo mil PHP";

echo "1. <br>";
if (preg_match('/php/i', $texto)){
    echo "Coincide <br>";
}else{
    echo "No coincide <br>";
}
echo "2. <br>";
$texto = "Hola mundo";
if (preg_match('/^Hola/', $texto)){
    echo "Empieza por Hola";
}

$dni = "12345678F";

if (preg_match("/^[0-9]{8}[a-z]{1}$/i", $dni)){
    echo "<br> DNI Correcto";
}else {
    echo "<br> DNI incorrecto";
}

$nie = "X1234567N";

if (preg_match("/^([0-9]{8}|[XYZ]{1}[0-9]{7})[A-Z]{1}$/", $nie)){
    echo "<br> Valido";
}else{
    echo "<br> invalido";
} 

$correo = "josejulio@educa.madrid.org";

if (preg_match("/^[a-z]{6,18}@educa\.madrid\.org$/", $correo)){
    echo "<br> correcto";
}

/*Validar un telefono español (9 digitos y empieza por 659 y terminar en 22) */

$numero_telefono = "659112322";

if (preg_match("/^659[0-9]{4}22$/", $numero_telefono)){
    echo "<br> Numero de telefono correcto";
}else echo " <br> Numero de telefono incorrecto";


/*Valida el formato Dia,Mes,Año en sus multiples formas 
1. 06-10-2026 
2. 06/10/2026
validar el formato y la fecha*/

$fecha = "20/06/2026";

if (preg_match("/(^[0-9]{2}-[0-9]{2}-[0-9]{4}$)|(^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$)/", $fecha)){
    echo "<br> Es correcto el formato de la fecha";
}else echo " <br> Formato Incorrecto";

/* DELIMITER //
CREATE TRIGGER aux AFTER UPDATE ON renta FOR EACH ROW
BEGIN
INSERT INTO audit_renta(renatal_id, customer_id, accion), VALUES (NEW.rental_id, NEW.customer.id, "rentado")
 END //
DELIMITER ; */

?>