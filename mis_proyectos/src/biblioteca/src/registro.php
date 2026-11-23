<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username        = trim($_POST['username'] ?? '');
    $password        = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $aceptaTerminos  = isset($_POST['terminos']);

    if (!$aceptaTerminos) {
        $error = "Debes aceptar los términos y condiciones para continuar.";
    } elseif (strlen($username) < 3) {
        $error = "El nombre de usuario debe tener al menos 3 caracteres.";
    } elseif (strlen($password) < 4) {
        $error = "La contraseña debe tener al menos 4 caracteres.";
    } elseif ($password !== $passwordConfirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Comprobar si el usuario ya existe en la base de datos
        $stmtCheck = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmtCheck->bind_param("s", $username);
        $stmtCheck->execute();
        $yaExiste = $stmtCheck->get_result()->num_rows > 0;
        $stmtCheck->close();

        if ($yaExiste) {
            $error = "El usuario '$username' ya está registrado. Elige otro.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmtIns = $conn->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, ?, 'usuario')");
            $stmtIns->bind_param("ss", $username, $hash);

            if ($stmtIns->execute()) {
                $stmtIns->close();
                header("Location: login.php?registrado=1");
                exit;
            } else {
                $error = "Error al crear la cuenta. Inténtalo de nuevo.";
            }
            $stmtIns->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Lector - Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="card login-card">
        <h2>📝 Crear Cuenta de Lector</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Nombre de usuario</label>
            <input type="text" id="username" name="username" minlength="3" required autofocus
                   value="<?= htmlspecialchars($username) ?>">

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" minlength="4" required>

            <label for="password_confirm">Repetir contraseña</label>
            <input type="password" id="password_confirm" name="password_confirm" minlength="4" required>

            <label class="checkbox-label">
                <input type="checkbox" name="terminos" required <?= isset($_POST['terminos']) ? 'checked' : '' ?>>
                <span>Acepto los términos y condiciones</span>
            </label>

            <button type="submit" class="btn primary">Registrarse</button>
        </form>

        <p class="auth-switch">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </p>
    </div>
</body>
</html>