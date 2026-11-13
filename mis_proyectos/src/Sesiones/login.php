<?php
session_start();
// Si ya está logueado, redirigir al panel
if (isset($_SESSION['usuario'])) {
header('Location: panel.php');
exit;
}
$USUARIO_VALIDO = 'admin';
$PASS_VALIDA = '1234';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$user = $_POST['usuario'] ?? '';
$pass = $_POST['password'] ?? '';
if ($user === $USUARIO_VALIDO && $pass === $PASS_VALIDA) {
// Seguridad: regenerar ID de sesión tras login
session_regenerate_id(true);
$_SESSION['usuario'] = $user;
$_SESSION['ultima_actividad'] = time();
header('Location: panel.php');
exit;
} else {
$error = 'Credenciales incorrectas';
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h1>Iniciar sesión</h1>
<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post">
<label>Usuario: <input name="usuario" required></label><br><br>
<label>Contraseña: <input name="password" type="password"
required></label><br><br>
<button>Entrar</button>
</form>
</body>
</html>