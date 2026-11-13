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
header("X-Version: 1.0");
?>