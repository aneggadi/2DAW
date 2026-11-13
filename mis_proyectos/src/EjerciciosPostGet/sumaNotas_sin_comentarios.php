<?php

//Introudciomos en la funcion un array de notas que devuelve un float,
function calcularMedia(array $notas): float
{
    $suma = 0;
    //Suma se usa como auxiliar para guardar la suma de todas las notas y recorremos todo el array sumando una por una las notas
    foreach ($notas as $nota) {
        $suma += $nota;
    }
    //En el caso de que haya un array vacio para que no de error devuelve directamente 0.0
    if (count($notas) === 0) {
        return 0.0;
    }
    //Si se da que el array np esta vacio devuelve la media (la suma de todas las notas / el numero de notas)
    return $suma / count($notas);
}
$resultado = null;
$errores   = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $notasEnviadas = $_POST['notas'] ?? []; //Coge las notas que se haya introducido y en caso de que no haya nada coge un array vacio

    $notas = [];

    foreach ($notasEnviadas as $valor) {
        $valor = trim($valor); //Devuelve las notas enviadas de forma continua en vez de en forma de array

        if ($valor === '') { //se comprueba que no esta vacio y en caso de que esta vacio salta al siguiente paso
            continue;
        }

        if (!is_numeric($valor)) { //Comprueba que sea un valor numerico en caso de que no sea numerico muestra un mensaje de error y pasa al siguiente paso
            $errores[] = "El valor '{$valor}' no es un número válido.";
            continue;
        }
        //Una vez pasada las barreras de seguridad las notas se guardan dentro del array notas en forma decimal
        $notas[] = (float) $valor;
    }

    if (empty($errores) && count($notas) > 0){ //Barrera de seguirdad que comprueba que no haya errores y que haya notas introducidas

        $media = calcularMedia($notas); 
        //Se calcula la media con la funcion anerior y en caso de que la media sea menor a 5 guarda el mensaje de suspenso
        //Entre 5 y 7 aprobado, entre 7 y 9 Notable y mayor o igual de nueve sobresaliente 
        if ($media < 5) {
            $clasificacion = "Suspenso";
        } elseif ($media >= 5 && $media < 7) {
            $clasificacion = "Aprobado";
        } elseif ($media >= 7 && $media < 9) {
            $clasificacion = "Notable";
        } else {
            $clasificacion = "Sobresaliente";
        }
        //Creamos un array asociativo donde para poder acceder las notas la media y la clasificacion (resultado)
        $resultado = [
            'notas'         => $notas,
            'media'         => $media,
            'clasificacion' => $clasificacion,
        ];
        //En el caso de que notas este vacio, pero no haya errores significa que no has introducido valores y te guarda un mensaje de error
    } elseif (count($notas) === 0 && empty($errores)) {
        $errores[] = "Debes introducir al menos una nota.";
    }
}

$numCampos = 3;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['notas'])) {
    $numCampos = max(1, count($_POST['notas']));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas del alumno</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; }
        .fila-nota { margin-bottom: .5rem; display: flex; gap: .5rem; align-items: center; }
        .fila-nota input { flex: 1; padding: .4rem; }
        .error { color: #b00; }
        .ok { background: #eef; padding: 1rem; border-radius: 6px; margin-top: 1rem; }
        button { padding: .5rem 1rem; margin-top: .5rem; cursor: pointer; }
        .btn-add { background: #4caf50; color: white; border: none; }
        .btn-del { background: #f44336; color: white; border: none; }
    </style>
</head>
<body>

    <h1>Introduce las notas del alumno</h1>

    <form method="post" action="" id="form-notas">

        <div id="contenedor-notas">
            <!--Se crea dentro de html un bucle para imprimr de forma repetida en vez de imprimir todo de golpe -->
            <?php for ($i = 0; $i < $numCampos; $i++): ?>
                <?php
                    $valorPrevio = $_POST['notas'][$i] ?? '';
                ?>
                <div class="fila-nota">
                    <input
                        type="number"
                        step="0.01"contenedor
                        min="0"
                        max="10"
                        name="notas[]"
                        placeholder="Nota <?php echo $i + 1; ?>"
                        value="<?php echo htmlspecialchars($valorPrevio); ?>">
                        <!-- Cuando se pulsa el bptpn llama a la funcion de javascrupit de eliminar cammpo y elimina el campo en el que esta actualmente-->
                    <button type="button" class="btn-del" onclick="eliminarCampo(this)">✕</button>
                </div>
            <?php endfor; ?>
        </div>
        <!--Pulsando el boton llama a la funcion de añadir campo de javascript -->
        <button tºype="button" class="btn-add" onclick="añadirCampo()">+ Añadir otra nota</button>
        <br>
        <button type="submit">Calcular media</button>
    </form>
    
    <!-- Comprueba si hay errores y en el caso de que haya errores los imprime uno por uno de forma ordenada con el ul y li-->
    <?php if (!empty($errores)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errores as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
                <!--Comprueba si hay resultados y en caso de que haya resultados imprime el array asociativo resultado donde 
                busca por la palabra clave e imprime los datos dentro de la palabra clave-->
    <?php if ($resultado !== null): ?>
        <div class="ok">
            <h2>Resultado</h2>
            <p><strong>Notas introducidas:</strong>
                <?php echo implode(', ', $resultado['notas']); ?>
            </p>
            <p><strong>Media:</strong>
                <?php echo number_format($resultado['media'], 2); ?>
            </p>
            <p><strong>Calificación:</strong>
                <?php echo htmlspecialchars($resultado['clasificacion']); ?>
            </p>
        </div>
    <?php endif; ?>

    <script>
        //Funciones javascript para añadir campos, estas funciones se llamaran posteriormente en el html
        function añadirCampo() {
            const contenedor = document.getElementById('contenedor-notas');
            const total = contenedor.querySelectorAll('.fila-nota').length;

            const fila = document.createElement('div');
            fila.className = 'fila-nota';
            fila.innerHTML = `
                <input type="number" step="0.01" min="0" max="10"
                       name="notas[]" placeholder="Nota ${total + 1}">
                <button type="button" class="btn-del" onclick="eliminarCampo(this)">✕</button>
            `;
            contenedor.appendChild(fila);
        }

        function eliminarCampo(boton) {
            const contenedor = document.getElementById('contenedor-notas');
            if (contenedor.querySelectorAll('.fila-nota').length > 1) {
                boton.parentElement.remove();
            } else {
                alert('Debe haber al menos un campo de nota.');
            }
        }
    </script>

</body>
</html>