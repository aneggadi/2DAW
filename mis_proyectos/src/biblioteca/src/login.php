<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Crear cuentas de prueba con hash real si no existen
$cuentasBase = [
    ['admin', '1234', 'admin'],
    ['lector', '1234', 'usuario']
];

foreach ($cuentasBase as [$u, $p, $r]) {
    $stmtCheck = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
    $stmtCheck->bind_param("s", $u);
    $stmtCheck->execute();
    if ($stmtCheck->get_result()->num_rows === 0) {
        $hash = password_hash($p, PASSWORD_DEFAULT);
        $stmtIns = $conn->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)");
        $stmtIns->bind_param("sss", $u, $hash, $r);
        $stmtIns->execute();
        $stmtIns->close();
    }
    $stmtCheck->close();
}

$error = "";
$mensaje = isset($_GET['registrado']) ? "Cuenta creada correctamente. Ya puedes iniciar sesión." : "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password, rol FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['usuario'] = $user['username'];
        $_SESSION['rol']     = $user['rol'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="card login-card">
        <h2>📚 Acceso Biblioteca</h2>
        <div class="hint">
            <div><strong>Admin:</strong> admin / 1234</div>
            <div><strong>Usuario:</strong> lector / 1234</div>
        </div>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($mensaje): ?>
            <div class="alert success"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" required autofocus>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn primary">Iniciar sesión</button>
        </form>

        <p class="auth-switch">
            ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
        </p>
    </div>
</body>
</html>