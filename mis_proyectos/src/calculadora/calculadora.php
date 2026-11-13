<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Calculator</h1>
    
    <form action="" method="get">
    
        <input type="number" name = "num1" placeholder= "Numero 1" required>
        <input type="number" name = "num1" placeholder= "Numero 1" required>
        
        <select name="operacion" id="">
            <option value="addition">Sumar</option>
            <option value="substraction">Restar</option>
            <option value="multiplication">Multiplicar</option>
            <option value="division">Dividir</option>
        </select>
        <button type="submit">Calcular</button>
    </form>

    <?php
        if (isset(($_GET['num1'] . $_GET['num2'] . $_GET['operation']))){
            $number1 = $_GET['num1'];
            $number2 = $_GET['num2'];
            $operationCal = $_GET['operation'];

            switch ($operationCal){
                case "addition":
                    $suma = $num1 + $num2;
                    break;
                case "substraction":
                    $resta = $num1 - $num2;
                    break;
                case "multiplication":
                    $multiplicacion = $num1 * $num2;
                    break;
                case "division":
                    $division = $num1 / $num2;
                    break;
            }
        }
    ?>
</body>
</html>