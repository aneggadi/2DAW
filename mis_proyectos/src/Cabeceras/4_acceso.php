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
?>