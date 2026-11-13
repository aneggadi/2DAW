Tutorial completo: 5 ejercicios de cabeceras HTTP en PHP
Consejo: crear una carpeta cabeceras/ y meter todos los archivos dentro.
Ejercicio 1: Leer las cabeceras de la solicitud
¿Qué aprendemos?
Que la request que envía el navegador trae metadatos (cabeceras) y que PHP puede leerlos con getallheaders().
Código: 1_info.php
php
<?php
// 1_info.php
// Mostramos todas las cabeceras de la solicitud (request)

header("Content-Type: text/html; charset=UTF-8");

$headers = getallheaders();

echo "<h1>Cabeceras de la solicitud</h1>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><th>Cabecera</th><th>Valor</th></tr>";

foreach ($headers as $nombre => $valor) {
    echo "<tr>";
    echo "<td><strong>" . htmlspecialchars($nombre) . "</strong></td>";
    echo "<td>" . htmlspecialchars($valor) . "</td>";
    echo "</tr>";
}

echo "</table>";
Cómo ejecutarlo
Guardar como 1_info.php en la carpeta del proyecto.
http://localhost:8000/1_info.php.
Qué deberían ver
Una tabla con cabeceras como:
Cabecera
Valor
Host
localhost:8000
User-Agent
Mozilla/5.0 ... Chrome/...
Accept
text/html,application/xhtml+xml,...
Accept-Language
es-ES,es;q=0.9
...
...

¿Por qué funciona?
getallheaders() devuelve un array asociativo con todas las cabeceras que el cliente ha enviado.
htmlspecialchars() evita que un valor con < o > rompa el HTML (buena práctica de seguridad).
El foreach recorre el array asociativo: $nombre es la clave, $valor el valor.
Reto extra
Añade al final un contador que diga cuántas cabeceras hay:
php
echo "<p>Total de cabeceras: " . count($headers) . "</p>";

Ejercicio 2: Detectar el navegador del usuario
¿Qué aprendemos?
A leer una cabecera concreta (User-Agent) desde $_SERVER y a analizarla con stripos().
Código: 2_navegador.php
php
<?php
// 2_navegador.php
// Detectamos el navegador a partir del User-Agent

header("Content-Type: text/html; charset=UTF-8");

$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';

// IMPORTANTE: comprobar Edge antes que Chrome,
// porque el UA de Edge también contiene "Chrome".
if (stripos($ua, 'Edg') !== false) {
    $navegador = "Microsoft Edge";
} elseif (stripos($ua, 'Firefox') !== false) {
    $navegador = "Mozilla Firefox";
} elseif (stripos($ua, 'Chrome') !== false) {
    $navegador = "Google Chrome";
} elseif (stripos($ua, 'Safari') !== false) {
    $navegador = "Safari";
} else {
    $navegador = "Navegador desconocido";
}

echo "<h1>Tu navegador</h1>";
echo "<p>Estás usando: <strong>" . htmlspecialchars($navegador) . "</strong></p>";
echo "<p>User-Agent completo:</p>";
echo "<pre>" . htmlspecialchars($ua) . "</pre>";
Cómo ejecutarlo
Abrir http://localhost:8000/2_navegador.php.
Qué deberían ver
Un mensaje como "Estás usando: Google Chrome" y debajo el User-Agent completo.
¿Por qué funciona?
En PHP, muchas cabeceras de solicitud se exponen en $_SERVER con el prefijo HTTP_ y en mayúsculas: User-Agent → $_SERVER['HTTP_USER_AGENT'].
?? 'desconocido' es el operador de coalescencia nula: evita un error si la cabecera no existe.
stripos() busca sin distinguir mayúsculas/minúsculas y devuelve la posición o false.
Orden importa: el UA de Edge contiene Chrome, así que hay que comprobar Edge primero.
Reto extra
Añade detección de sistema operativo: si el UA contiene Windows, Mac o Linux, mostrar mensaje correspondiente.

Ejercicio 3: Enviar cabeceras de respuesta personalizadas
¿Qué aprendemos?
A enviar cabeceras de respuesta con header(), y por qué debe hacerse antes de cualquier salida.
Código: 3_saludo.php
php
<?php
// 3_saludo.php
// Enviamos cabeceras de respuesta personalizadas

// 1) Cabecera estándar: tipo de contenido
header("Content-Type: text/plain; charset=UTF-8");

// 2) Cabecera personalizada (empieza por X-)
header("X-Saludo: Hola desde PHP");

// 3) Otra cabecera personalizada
header("X-Autor: Tu Nombre");

// Ahora sí, podemos escribir la salida
echo "Cabecera enviada correctamente.\n";
echo "Mira las DevTools → Network → Response Headers.\n";
Cómo ejecutarlo
Abrir http://localhost:8000/3_saludo.php.
Abrir F12 → Network → recargar → clic en 3_saludo.php → Response Headers.
Qué deberían ver
En pantalla:
text
Cabecera enviada correctamente.
Mira las DevTools → Network → Response Headers.
En Network, entre las cabeceras de respuesta:
text
X-Saludo: Hola desde PHP
X-Autor: Tu Nombre
Content-Type: text/plain; charset=UTF-8
¿Por qué funciona?
header("Nombre: valor") añade una cabecera a la response.
Las cabeceras personalizadas por convenio empiezan por X- (aunque el estándar moderno ya no lo exige).
Regla de oro: header() debe llamarse antes de cualquier echo, HTML o espacio en blanco. Si no, PHP lanza:
text
Warning: Cannot modify header information - headers already sent
Porque las cabeceras se envían al principio de la respuesta, junto con los primeros bytes.
Comprobación práctica
Cambia el orden: pon un echo antes de header(). Verás el warning. Vuelve a dejarlo bien. Eso enseña el error en vivo.
Reto extra
Añade header("X-Version: 1.0"); y compruébalo en Network.

Ejercicio 4: Redirección condicional con Location
¿Qué aprendemos?
Cabecera Location para redirigir.
Códigos de estado con http_response_code().
Por qué el exit es obligatorio.
Cabecera Cache-Control para evitar cachés indeseadas.
Código: 4_acceso.php
php
<?php
// 4_acceso.php
// Simula control de acceso con redirecciones

header("Cache-Control: no-store");

$perfil = $_GET['perfil'] ?? null;

if ($perfil === 'admin') {
    header("Location: 4_admin.php");
    exit; // ¡OBLIGATORIO!
} elseif ($perfil === 'usuario') {
    header("Location: 4_usuario.php");
    exit;
} else {
    http_response_code(403);
    header("Content-Type: text/plain; charset=UTF-8");
    echo "403 Forbidden: acceso denegado.\n";
    echo "Prueba con ?perfil=admin o ?perfil=usuario\n";
}
Archivos auxiliares
4_admin.php:
php
<?php
header("Content-Type: text/html; charset=UTF-8");
echo "<h1>Panel de administración</h1>";
echo "<p>Bienvenido, administrador.</p>";
echo "<p><a href='4_acceso.php'>Volver</a></p>";
4_usuario.php:
php
<?php
header("Content-Type: text/html; charset=UTF-8");
echo "<h1>Zona de usuario</h1>";
echo "<p>Bienvenido, usuario.</p>";
echo "<p><a href='4_acceso.php'>Volver</a></p>";
Cómo probarlo
http://localhost:8000/4_acceso.php → debe mostrar 403 Forbidden.
http://localhost:8000/4_acceso.php?perfil=admin → redirige a 4_admin.php.
http://localhost:8000/4_acceso.php?perfil=usuario → redirige a 4_usuario.php.
Qué deberían ver en Network
Sin perfil: Status 403.
Con ?perfil=admin: Status 302 (Found) en la primera petición, con cabecera Location: 4_admin.php. El navegador hace una segunda petición a 4_admin.php que devuelve 200.
¿Por qué funciona?
header("Location: ...") indica al navegador que vaya a otra URL. No detiene el script por sí sola: hay que añadir exit.
Si no pones exit, el código siguiente se ejecuta (aunque el navegador ya esté redirigiendo). Esto puede ser un fallo de seguridad: el servidor seguiría procesando lógica.
http_response_code(403) fija el código de estado de la respuesta.
Cache-Control: no-store impide que el navegador o un proxy cacheen la respuesta (importante en redirecciones y control de acceso).
Demostración del error sin exit
Quita el exit del caso admin y añade un echo "Esto no debería verse"; después. Verás que, aunque el navegador redirige, el servidor ejecuta el echo. Eso es justo el bug que evita exit.
Reto extra
Añade un tercer perfil ?perfil=invitado que redirija a 4_usuario.php.

Ejercicio 5: Descargar un CSV generado por PHP
¿Qué aprendemos?
Content-Type y Content-Disposition.
Generar contenido dinámico que se descarga como archivo.
Combinar arrays, foreach y cabeceras.
Código: 5_exportar.php
php
<?php
// 5_exportar.php
// Generamos un CSV y forzamos su descarga

// 1) Cabeceras de respuesta
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"notas.csv\"");
header("Cache-Control: no-cache");

// 2) Datos
$alumnos = [
    ["id" => 1, "nombre" => "Ana",   "nota" => 7],
    ["id" => 2, "nombre" => "Luis",  "nota" => 4],
    ["id" => 3, "nombre" => "Marta", "nota" => 9],
    ["id" => 4, "nombre" => "Pedro", "nota" => 5],
    ["id" => 5, "nombre" => "Sofía", "nota" => 8],
];

// 3) Escribimos al flujo de salida
$salida = fopen("php://output", "w");

// Cabecera del CSV
fputcsv($salida, ["id", "nombre", "nota"]);

// Filas
foreach ($alumnos as $alumno) {
    fputcsv($salida, $alumno);
}

fclose($salida);
Cómo probarlo
Abrir http://localhost:8000/5_exportar.php.
Qué deberían ver
El navegador descarga un archivo notas.csv.
Al abrirlo (Excel, LibreOffice, VSCode...):
text
id,nombre,nota
1,Ana,7
2,Luis,4
3,Marta,9
4,Pedro,5
5,Sofía,8
En DevTools → Network, verán en las Response Headers:
text
Content-Type: text/csv; charset=UTF-8
Content-Disposition: attachment; filename="notas.csv"
Cache-Control: no-cache
¿Por qué funciona?
Content-Type: text/csv le dice al navegador que el contenido es CSV.
Content-Disposition: attachment; filename="notas.csv" le dice "no lo muestres, descárgalo con este nombre".
Si fuera inline, el navegador intentaría mostrarlo.
php://output es un flujo especial que escribe directamente en la respuesta HTTP; no se guarda en disco.
fputcsv() formatea correctamente cada fila, escapando comas, comillas y saltos de línea cuando es necesario.
¿Por qué no usar echo con concatenación?
Podrías hacer:
php
echo "id,nombre,nota\n";
foreach ($alumnos as $a) {
    echo $a['id'] . "," . $a['nombre'] . "," . $a['nota'] . "\n";
}
Funciona para datos simples, pero falla si un nombre contiene una coma o comillas. fputcsv() se encarga de escapar correctamente. Es la opción profesional.
Reto extra
Añade una columna aprobado (SI/NO según la nota ≥ 5).
Cambia el nombre del archivo para que incluya la fecha: notas_2026-10-29.csv. Pista:
php
$fecha = date("Y-m-d");
header("Content-Disposition: attachment; filename=\"notas_$fecha.csv\"");

Resumen final para los alumnos
Ejercicio
Cabecera trabajada
Dónde se ve
1
Todas las de request
getallheaders()
2
User-Agent
$_SERVER['HTTP_USER_AGENT']
3
X-* personalizadas + Content-Type
DevTools → Response Headers
4
Location, Cache-Control, código 403
DevTools → Status
5
Content-Type, Content-Disposition
Descarga del archivo

Reglas de oro que deben recordar
header() siempre antes de cualquier salida (echo, HTML, espacios).
exit después de Location, siempre.
Las cabeceras de request se leen desde $_SERVER (prefijo HTTP_) o getallheaders().
Las cabeceras de response se envían con header().
Los códigos de estado se fijan con http_response_code().
Content-Disposition: attachment fuerza la descarga.
php://output + fputcsv() es la forma limpia de generar CSVs.

