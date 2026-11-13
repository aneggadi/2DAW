------------------------------------------------------------
EJERCICIO 1 - GET: SALUDO PERSONALIZADO
------------------------------------------------------------
<br>
<!-- Objetivo: practicar method="get", $_GET y ver los datos
en la URL. -->

Archivo: saludo.php

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Saludo GET</title>
</head>

<body>

    <h1>Saludo personalizado</h1>

    <!-- TODO 1: crea un formulario que envíe por GET a esta
         misma página con dos campos: nombre y ciudad -->
    
    <form method="get" action="">
        <input type="text" name = "nombre" placeholder= "Nombre" required>
        <input type="text" name = "ciudad" placeholder= "Ciudad" required>
        <button type="submit">Enviar</button>

    </form>

    <?php
    // TODO 2: si llegan 'nombre' y 'ciudad' por GET,
    // muestra: "Hola [nombre], ¿qué tal por [ciudad]?"
    // Usa htmlspecialchars() para escapar.
    if (isset(($_GET['nombre'])) && isset(($_GET['ciudad']))){
        echo "Hola " . $_GET['nombre'] . " ¿Qué tal por " . $_GET['ciudad'];
    }
        
    ?>

</body>

</html>
<!--
    /*
    #Pistas:
    <form method="get" action="">
        - isset($_GET['nombre'], $_GET['ciudad'])
        - Mira la URL después de enviar: ?nombre=Ana&ciudad=Sevilla
        
        Resultado esperado:
        Al enviar "Ana" / "Sevilla":
        Hola Ana, ¿qué tal por Sevilla?
        En la barra:
        saludo.php?nombre=Ana&ciudad=Sevilla
        */
        -->

    <br>
    ------------------------------------------------------------
    EJERCICIO 2 - POST: MEDIA DE 3 NOTAS
    ------------------------------------------------------------
    <br>
    <!--Objetivo: practicar method="post", $_POST y operaciones. -->

    Archivo: media.php

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Media POST</title>
    </head>

    <body>

        <h1>Media de 3 notas</h1>
            <form action="" method="post"> 
                <input type="number" name = "n1" placeholder= "Numero 1" required>
                <input type="number" name = "n2" placeholder= "Numero 2" required>
                <input type="number" name = "n3" placeholder= "Numero 3" required>
                <button type="submit">Calcular</button>
            </form>

        <!-- TODO 1: formulario con method="post" y 3 inputs
         type="number" (name="n1", "n2", "n3") + botón
         Calcular -->

        <?php
        // TODO 2: si la petición es POST:
        //   - recoge n1, n2, n3
        //   - valida que sean números entre 0 y 10
        //   - calcula la media
        //   - muestra "Media: X" o un error si algo falla
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if (isset($_POST['n1']) && isset($_POST['n2']) && isset($_POST['n3'])
                    && is_numeric($_POST['n1']) && is_numeric($_POST['n2']) && is_numeric($_POST['n3']) ) {
                    if ($_POST['n1'] >= 0 && $_POST['n1'] <= 10 && $_POST['n2'] >= 0 && $_POST['n2'] <= 10 &&
                    $_POST['n3'] >= 0 && $_POST['n3'] <= 10){
                        $n1 = $_POST['n1'];
                        $n2 = $_POST['n2'];
                        $n3 = $_POST['n3'];
                        $media = ($n1 + $n2 + $n3)/3;
                        echo "Media $media";
                        }else{
                            echo "Valores fuera de rango";
                        }
                    }
                
            }
        ?>

    </body>
    </html>

<!-- 
    Pistas:
    - $_SERVER['REQUEST_METHOD'] === 'POST'
    - is_numeric()
    - ($n1 + $n2 + $n3) / 3
    - round($media, 2)
    
    Resultado esperado:
    - 7, 8, 9 -> Media: 8
    - 7, 8, 15 -> Error: las notas deben estar entre 0 y 10
    - a, b, c -> Error: solo números
--> 

    

<br>
------------------------------------------------------------
EJERCICIO 3 - GET vs POST LADO A LADO (el más didáctico)
------------------------------------------------------------
<br>
<!--Objetivo: ver con los ojos la diferencia entre ambos.-->
Archivo: comparar.php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GET vs POST</title>
</head>
<body>
    <h1>GET vs POST</h1>
    <!-- TODO 1: dos formularios idénticos, uno con
     method="get" y otro con method="post", con un solo
     campo name="texto" -->
    <hr><br>
    Formulario Metodo Get:
    <form method = "get" action="">
        <input type="text" name = "texto" id = "metodoget">
        <button type= "submit">Introducir</button>
    </form>
    <br>
    Formulario metodo Post: 
    <form method = "post" action="">
        <input type="text" name = "texto" id = "metodopost">
        <button type = "submit">Introducir</button>
    </form>
    <?php
    // TODO 2: muestra:
    //   - el contenido de $_GET (si hay algo)
    //   - el contenido de $_POST (si hay algo)
    // Usa print_r() dentro de <pre> para verlo bien
    
    if (isset($_GET['metodoget'])){
        echo "Metodo get: ".$_GET['metodoget'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'post'){
            if(isset($_POST['metodopost'])){
                echo "Metodo post: " . $_POST['metodopost'];
                }
                }
            //<pre>print_r($_GET)</pre>
        ?>
 <!--   Pistas:
    - Envía el mismo texto en ambos y compara.
    - El de GET aparece en la URL. El de POST NO.
    - print_r($_GET) dentro de
    <pre>...</pre>

    Lo que debes observar:
    GET : se ve en la URL, se puede marcar la página,
    F5 repite sin avisar.
    POST: NO se ve en la URL, F5 pregunta "¿reenviar
    formulario?". -->
</body>
</html>
    <br>
    ------------------------------------------------------------
    EJERCICIO 4 - GET: MINI BUSCADOR (con array, sin BD)
    ------------------------------------------------------------
    <br>
    <!--Objetivo: practicar GET como método "de consulta".-->

    Archivo: buscador.php

    <?php
    // Lista de frutas (simula una base de datos)
    $frutas = [
        "manzana",
        "plátano",
        "naranja",
        "fresa",
        "kiwi",
        "mango",
        "pera",
        "uva",
        "sandía",
        "melón"
    ];
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Buscador GET</title>
    </head>

    <body>

        <h1>Buscador de frutas</h1>
        <!-- TODO 1: formulario GET con un input name="buscar" -->
        <form method = "get" action="">
            <input type="text" name = "buscar" id = "buscar">
            <button type = "submit">Buscar</button>
        </form>
        
        <?php
        // TODO 2: si llega $_GET['buscar']:
        //   - recórrelo con foreach
        //   - muestra solo las frutas que CONTENGAN el texto
        //   - si no hay ninguna, muestra "Sin resultados"
        //   - si el campo está vacío, muestra "Escribe algo".
        $frutas = [
        "manzana",
        "plátano",
        "naranja",
        "fresa",
        "kiwi",
        "mango",
        "pera",
        "uva",
        "sandía",
        "melón"
    ];
    //stripos();
        $encontrado = FALSE;
        if(empty($_GET['buscar'])){
            echo "Esta vacio escribe algo porfavor";
            }else{
            foreach($frutas as $fruta){
                if (stripos($fruta ,$_GET['buscar'])!== FALSE){
                    echo "$fruta \n";
                    $encontrado = TRUE;
                }
            }
            if ($encontrado == FALSE){
                echo "No se ha encotrado en la base de datos";
            }
        }
        ?>

    </body>

    </html>

   <!-- Pistas:
    - stripos($fruta, $buscar) !== false -> contiene
    - empty($_GET['buscar'])
    - foreach ($frutas as $f)

    Resultado esperado:
    - Buscar "na" -> naranja, sandía (contienen "na")
    - Buscar "xyz" -> Sin resultados
    - Buscar vacío -> Escribe algo -->

<br>
  ------------------------------------------------------------
    EJERCICIO 5 - POST: FORMULARIO DE CONTACTO VALIDADO
    ------------------------------------------------------------
    <br>
    <!--Objetivo: practicar POST + validación (lo más realista).-->

    Archivo: contacto.php

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Contacto POST</title>
    </head>

    <body>

        <h1>Contacto</h1>

        <!-- TODO 1: formulario POST con:
         - nombre  (text,     required)
         - email   (email,    required)
         - mensaje (textarea, required, maxlength 200) -->
        <form method = "post" action="">
            <input type = "text" id = "nombre" name = "nombre" required>
            <input type = "email" id = "email" name = "email" required>
            <textarea name="mensaje" id="mensaje" maxlength="200" required></textarea>
            <button type="submit">Enviar</button>
        </form>

        <?php
            // TODO 2: si es POST:
            //   - recoge los 3 campos
            //   - valida:
            //       * nombre no vacío y >= 3 letras
            //       * email con filter_var(..., FILTER_VALIDATE_EMAIL)
            //       * mensaje entre 10 y 200 caracteres
            //   - si todo OK, muestra "Gracias, [nombre].
            //     Mensaje recibido."
            //   - si hay errores, muéstralos en una lista <ul>

            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $mensaje = $_POST['mensaje'];
            $errores = [];
            if (empty($nombre) != TRUE && strlen($nombre) >= 3 && filter_var($email, FILTER_VALIDATE_EMAIL) &&
            $mensaje >= 10 && $mensaje <= 200){
                echo "Gracias $nombre";
            }else echo filter_var($email, FILTER_VALIDATE_EMAIL);
        ?>

    </body>

    </html>

   <!--
    Pistas:
    - filter_var($email, FILTER_VALIDATE_EMAIL)
    - strlen($mensaje)
    - Guarda errores en $errores = []; y usa foreach
    al mostrarlos.
    -->

