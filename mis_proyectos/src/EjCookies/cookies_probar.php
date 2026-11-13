============================================================
EJERCICIOS DE COOKIES EN PHP - CÓDIGO COMPLETO
============================================================
Requisitos: PHP 7.3+ (por la sintaxis de array en setcookie)
Servidor local: php -S localhost:8000
Abrir: http://localhost:8000/nombre_archivo.php
============================================================


------------------------------------------------------------
EJERCICIO 1: Crear y leer una cookie simple
Archivo: 1_cookie_basica.php
------------------------------------------------------------
<?php
// 1_cookie_basica.php
header("Content-Type: text/html; charset=UTF-8");

if (!isset($_COOKIE['nombre'])) {
    // No existe: la creamos (1 hora de duración)
    setcookie("nombre", "Ana", time() + 3600);
    echo "<h1>Cookie creada</h1>";
    echo "<p>Se ha creado la cookie 'nombre' con valor 'Ana'.</p>";
    echo "<p><strong>Recarga la página</strong> para verla.</p>";
} else {
    // Existe: mostramos su valor
    echo "<h1>Cookie encontrada</h1>";
    echo "<p>Valor de 'nombre': <strong>" . htmlspecialchars($_COOKIE['nombre']) . "</strong></p>";
    echo "<p><a href='4_borrar.php'>Borrar la cookie</a></p>";
}
?>


------------------------------------------------------------
EJERCICIO 2: Contador de visitas con cookie
Archivo: 2_contador.php
------------------------------------------------------------
<?php
// 2_contador.php
header("Content-Type: text/html; charset=UTF-8");

$visitas = isset($_COOKIE['visitas']) ? (int) $_COOKIE['visitas'] : 0;
$visitas++;

// 30 días de duración
setcookie("visitas", $visitas, time() + 60 * 60 * 24 * 30);

echo "<h1>Contador de visitas</h1>";

if ($visitas === 1) {
    echo "<p>Bienvenido, es tu primera visita.</p>";
} else {
    echo "<p>Has visitado esta página <strong>$visitas</strong> veces.</p>";
}

echo "<p><em>Recarga la página para incrementar el contador.</em></p>";
echo "<p><a href='2_contador.php?reset=1'>Resetear contador</a></p>";

// Reset opcional
if (isset($_GET['reset'])) {
    setcookie("visitas", "", time() - 3600);
    unset($_COOKIE['visitas']);
    header("Location: 2_contador.php");
    exit;
}
?>


------------------------------------------------------------
EJERCICIO 3: Cookie con fecha de expiración y formato
Archivo: 3_expiracion.php
------------------------------------------------------------
<?php
// 3_expiracion.php
header("Content-Type: text/html; charset=UTF-8");

$expiracion = time() + 60 * 60 * 24 * 7; // 7 días
$ahora = date("Y-m-d H:i:s");

echo "<h1>Última visita y expiración</h1>";

if (isset($_COOKIE['ultima_visita'])) {
    echo "<p>Tu última visita fue: <strong>" . htmlspecialchars($_COOKIE['ultima_visita']) . "</strong></p>";
} else {
    echo "<p>No había visita previa registrada.</p>";
}

// Creamos/actualizamos la cookie
setcookie("ultima_visita", $ahora, $expiracion);

echo "<p>Visita actual registrada: <strong>$ahora</strong></p>";
echo "<p>Esta cookie expirará el: <strong>" . date("Y-m-d H:i:s", $expiracion) . "</strong></p>";
echo "<p><em>Recarga para ver cómo cambia.</em></p>";
?>


------------------------------------------------------------
EJERCICIO 4: Borrar una cookie
Archivo: 4_borrar.php
------------------------------------------------------------
<?php
// 4_borrar.php
header("Content-Type: text/html; charset=UTF-8");

echo "<h1>Borrar cookie</h1>";

if (isset($_COOKIE['nombre'])) {
    // 1) Expiración en el pasado
    setcookie("nombre", "", time() - 3600);
    // 2) Eliminarla también de $_COOKIE en esta misma petición
    unset($_COOKIE['nombre']);

    echo "<p>Cookie 'nombre' <strong>eliminada</strong>.</p>";
} else {
    echo "<p>No hay cookie 'nombre' que borrar.</p>";
}

echo "<p><a href='1_cookie_basica.php'>Ir al ejercicio 1</a></p>";
?>


------------------------------------------------------------
EJERCICIO 5: Cookie con ámbito de ruta (path)
Archivos:
- 5_set_cookie.php (en la raíz)
- 5_leer_cookie.php (copiar a la raíz y a /admin/)
------------------------------------------------------------

### 5_set_cookie.php
<?php
// 5_set_cookie.php
header("Content-Type: text/html; charset=UTF-8");

setcookie("seccion", "admin", [
    'expires' => time() + 3600,
    'path' => '/admin/',   // Solo se enviará bajo /admin/
    'httponly' => true,
    'samesite' => 'Lax'
]);

echo "<h1>Cookie 'seccion' creada</h1>";
echo "<p>Valor: <strong>admin</strong></p>";
echo "<p>Ámbito: <code>/admin/</code></p>";
echo "<p>Prueba ahora:</p>";
echo "<ul>";
echo "<li><a href='5_leer_cookie.php'>/5_leer_cookie.php</a> → NO debería verla</li>";
echo "<li><a href='admin/5_leer_cookie.php'>/admin/5_leer_cookie.php</a> → SÍ debería verla</li>";
echo "</ul>";
?>

### 5_leer_cookie.php
<?php
// 5_leer_cookie.php
header("Content-Type: text/html; charset=UTF-8");

echo "<h1>Leer cookie 'seccion'</h1>";
echo "<p>Ruta actual: <code>" . htmlspecialchars($_SERVER['REQUEST_URI']) . "</code></p>";

if (isset($_COOKIE['seccion'])) {
    echo "<p>Cookie encontrada: <strong>" . htmlspecialchars($_COOKIE['seccion']) . "</strong></p>";
} else {
    echo "<p>La cookie NO está disponible en esta ruta.</p>";
}

echo "<p><a href='5_set_cookie.php'>Volver</a></p>";
?>


------------------------------------------------------------
EJERCICIO 6: Cookie segura (HttpOnly, Secure, SameSite)
Archivo: 6_cookie_segura.php
------------------------------------------------------------
<?php
// 6_cookie_segura.php
header("Content-Type: text/html; charset=UTF-8");

$valor = bin2hex(random_bytes(16));

setcookie("sesion_demo", $valor, [
    'expires' => time() + 3600,
    'path' => '/',
    'httponly' => true,     // No accesible desde JavaScript
    'secure' => false,    // Cambiar a true si pruebas con HTTPS
    'samesite' => 'Strict'  // No se envía en peticiones cross-site
]);

echo "<h1>Cookie segura creada</h1>";
echo "<p>Valor generado: <code>" . htmlspecialchars($valor) . "</code></p>";

echo "<h2>Atributos aplicados</h2>";
echo "<ul>";
echo "<li><strong>HttpOnly:</strong> bloquea el acceso desde JavaScript (defensa contra XSS).</li>";
echo "<li><strong>Secure:</strong> solo se envía por HTTPS (en local con HTTP no se envía).</li>";
echo "<li><strong>SameSite=Strict:</strong> no se envía en peticiones desde otros sitios (defensa contra CSRF).</li>";
echo "</ul>";

echo "<h2>Prueba con JavaScript</h2>";
echo "<p>Pulsa el botón: si HttpOnly funciona, NO verás <code>sesion_demo</code>.</p>";
echo "<button onclick=\"document.getElementById('salida').textContent = 'document.cookie = ' + document.cookie;\">Leer document.cookie</button>";
echo "<pre id='salida'></pre>";
?>


------------------------------------------------------------
EJERCICIO 7: Caso práctico — Recordar tema preferido
Archivos:
- 7_tema.php
- 7_reset.php
------------------------------------------------------------

### 7_tema.php
<?php
// 7_tema.php
header("Content-Type: text/html; charset=UTF-8");

// Si llega ?tema=claro|oscuro, guardamos en cookie y redirigimos
if (isset($_GET['tema'])) {
    $tema = ($_GET['tema'] === 'oscuro') ? 'oscuro' : 'claro';
    setcookie("tema", $tema, time() + 60 * 60 * 24 * 365); // 1 año
    header("Location: 7_tema.php");
    exit;
}

$tema = $_COOKIE['tema'] ?? 'claro';
$fondo = ($tema === 'oscuro') ? '#222' : '#fff';
$texto = ($tema === 'oscuro') ? '#eee' : '#000';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tema preferido</title>
    <style>
        body {
            background-color: <?= $fondo ?>;
            color: <?= $texto ?>;
            font-family: sans-serif;
            padding: 2rem;
            transition: background 0.3s, color 0.3s;
        }

        a.button {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            background: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h1>Preferencia de tema</h1>
    <p>Tema actual: <strong>
            <?= htmlspecialchars($tema) ?>
        </strong></p>

    <p>
        <a class="button" href="7_tema.php?tema=claro">Tema claro</a>
        <a class="button" href="7_tema.php?tema=oscuro">Tema oscuro</a>
    </p>

    <p><a href="7_reset.php" style="color:#e74c3c;">Resetear preferencia</a></p>
</body>

</html>

### 7_reset.php
<?php
// 7_reset.php
header("Content-Type: text/html; charset=UTF-8");

setcookie("tema", "", time() - 3600, '/');
unset($_COOKIE['tema']);

header("Location: 7_tema.php");
exit;
?>


============================================================
RÚBRICA RÁPIDA
============================================================
| Ejercicio | Se evalúa | Puntos |
|-----------|-------------------------------------------------------|--------|
| 1 | setcookie(), lectura, expiración simple | 1 |
| 2 | Lectura condicional, actualización, cálculo 30 días | 1 |
| 3 | Formato de fecha, expiración, mostrar caducidad | 1.5 |
| 4 | Borrado con expiración en el pasado, unset() | 1 |
| 5 | Parámetro path y ámbito | 1.5 |
| 6 | Atributos de seguridad (HttpOnly, Secure, SameSite) | 2 |
| 7 | Caso práctico completo con persistencia y reset | 2 |
| TOTAL | | 10 |


============================================================
REGLAS DE ORO
============================================================
1. setcookie() SIEMPRE antes de cualquier salida (echo, HTML, espacios, BOM).
2. La cookie NO aparece en $_COOKIE hasta la SIGUIENTE petición.
3. Para borrar: expiración en el pasado + unset($_COOKIE[...]) si se necesita en el mismo script.
4. path restringe el ámbito de la cookie a una ruta.
5. Nunca guardar datos sensibles en cookies (viajan en claro en cada petición).
6. Usar siempre HttpOnly, Secure y SameSite en cookies de sesión.
7. Límite aproximado: 4 KB por cookie y ~50 cookies por dominio.
8. Para pruebas locales con 'secure' => true, usar HTTPS o se ignorará la cookie.


============================================================
ESTRUCTURA DE CARPETAS SUGERIDA
============================================================
cookies/
├── 1_cookie_basica.php
├── 2_contador.php
├── 3_expiracion.php
├── 4_borrar.php
├── 5_set_cookie.php
├── 5_leer_cookie.php
├── 6_cookie_segura.php
├── 7_tema.php
├── 7_reset.php
└── admin/
└── 5_leer_cookie.php

Abrir: http://localhost:8000/1_cookie_basica.php
============================================================