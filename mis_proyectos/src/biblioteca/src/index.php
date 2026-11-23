<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId  = (int)$_SESSION['user_id'];
$rol     = $_SESSION['rol'];
$esAdmin = ($rol === 'admin');
$errorMsg = "";

// ==========================================
// 1. PRESTAR LIBRO (Resta 1 copia disponible)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['prestar'])) {
    $libroId = (int)$_POST['libro_id'];
    $destinatarioId = $esAdmin ? (int)$_POST['usuario_id'] : $userId;

    $stmtUpd = $conn->prepare("UPDATE libros SET copias_disponibles = copias_disponibles - 1 WHERE id = ? AND copias_disponibles > 0");
    $stmtUpd->bind_param("i", $libroId);
    $stmtUpd->execute();

    if ($stmtUpd->affected_rows > 0) {
        $stmtPrest = $conn->prepare("INSERT INTO prestamos (libro_id, usuario_id) VALUES (?, ?)");
        $stmtPrest->bind_param("ii", $libroId, $destinatarioId);
        $stmtPrest->execute();
        $stmtPrest->close();
    }
    $stmtUpd->close();
    header("Location: index.php");
    exit;
}

// ==========================================
// 2. DEVOLVER LIBRO (Suma 1 copia disponible)
// ==========================================
if (isset($_GET['devolver'])) {
    $prestamoId = (int)$_GET['devolver'];

    if ($esAdmin) {
        $stmt = $conn->prepare("SELECT libro_id FROM prestamos WHERE id = ? AND fecha_devolucion IS NULL");
        $stmt->bind_param("i", $prestamoId);
    } else {
        $stmt = $conn->prepare("SELECT libro_id FROM prestamos WHERE id = ? AND usuario_id = ? AND fecha_devolucion IS NULL");
        $stmt->bind_param("ii", $prestamoId, $userId);
    }

    $stmt->execute();
    $prestamo = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($prestamo) {
        $libroId = (int)$prestamo['libro_id'];
        $conn->query("UPDATE prestamos SET fecha_devolucion = NOW() WHERE id = $prestamoId");
        $conn->query("UPDATE libros SET copias_disponibles = LEAST(total_copias, copias_disponibles + 1) WHERE id = $libroId");
    }
    header("Location: index.php");
    exit;
}

// ==========================================
// 3. GESTIÓN DEL CATÁLOGO (Solo Admin)
// ==========================================
if ($esAdmin) {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar_libro'])) {
        $id          = $_POST['id'] ?? '';
        $titulo      = trim($_POST['titulo']);
        $autor       = trim($_POST['autor']);
        $anio        = (int)$_POST['anio'];
        $totalCopias = max(1, (int)$_POST['total_copias']);

        if (!empty($id)) {
            $id = (int)$id;
            // Calcular cuántas copias están actualmente prestadas para recalcular las disponibles
            $stmtCheck = $conn->prepare("SELECT total_copias, copias_disponibles FROM libros WHERE id = ?");
            $stmtCheck->bind_param("i", $id);
            $stmtCheck->execute();
            $actual = $stmtCheck->get_result()->fetch_assoc();
            $stmtCheck->close();

            if ($actual) {
                $prestadas = $actual['total_copias'] - $actual['copias_disponibles'];
                if ($totalCopias < $prestadas) {
                    $errorMsg = "No puedes reducir el total a $totalCopias porque ahora mismo hay $prestadas ejemplares prestados.";
                } else {
                    $nuevasDisponibles = $totalCopias - $prestadas;
                    $stmt = $conn->prepare("UPDATE libros SET titulo = ?, autor = ?, anio = ?, total_copias = ?, copias_disponibles = ? WHERE id = ?");
                    $stmt->bind_param("ssiiii", $titulo, $autor, $anio, $totalCopias, $nuevasDisponibles, $id);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: index.php");
                    exit;
                }
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, anio, total_copias, copias_disponibles) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiii", $titulo, $autor, $anio, $totalCopias, $totalCopias);
            $stmt->execute();
            $stmt->close();
            header("Location: index.php");
            exit;
        }
    }

    if (isset($_GET['borrar'])) {
        $id = (int)$_GET['borrar'];
        $stmt = $conn->prepare("DELETE FROM libros WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit;
    }
}

$libroEditar = null;
if ($esAdmin && (isset($_GET['editar']) || (!empty($errorMsg) && !empty($_POST['id'])))) {
    $id = isset($_GET['editar']) ? (int)$_GET['editar'] : (int)$_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $libroEditar = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// ==========================================
// 4. CONSULTAS PARA MOSTRAR EN PANTALLA
// ==========================================
$libros = $conn->query("SELECT * FROM libros ORDER BY id DESC");
$librosDisponibles = $conn->query("SELECT * FROM libros WHERE copias_disponibles > 0 ORDER BY titulo ASC");

if ($esAdmin) {
    $usuarios = $conn->query("SELECT id, username FROM usuarios WHERE rol = 'usuario' ORDER BY username ASC");
    $prestamosActivos = $conn->query("
        SELECT p.id, p.fecha_prestamo, l.titulo, l.autor, u.username
        FROM prestamos p
        JOIN libros l ON p.libro_id = l.id
        JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.fecha_devolucion IS NULL
        ORDER BY p.fecha_prestamo DESC
    ");
} else {
    $misPrestamos = $conn->prepare("
        SELECT p.id, p.fecha_prestamo, l.titulo, l.autor, l.anio
        FROM prestamos p
        JOIN libros l ON p.libro_id = l.id
        WHERE p.usuario_id = ? AND p.fecha_devolucion IS NULL
        ORDER BY p.fecha_prestamo DESC
    ");
    $misPrestamos->bind_param("i", $userId);
    $misPrestamos->execute();
    $resultadoMisPrestamos = $misPrestamos->get_result();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - <?= $esAdmin ? 'Administración' : 'Portal Lector' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <h1>📚 Biblioteca <span class="role-tag"><?= $esAdmin ? 'Admin' : 'Lector' ?></span></h1>
    <div>
        <span>Hola, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></span>
        <a href="logout.php" class="btn danger small">Cerrar sesión</a>
    </div>
</header>

<main class="container">

    <?php if ($errorMsg): ?>
        <div class="alert error"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <?php if ($esAdmin): ?>
        <!-- ==================== VISTA ADMINISTRADOR ==================== -->

        <!-- 1. REGISTRAR NUEVO PRÉSTAMO -->
        <section class="card">
            <h3>🤝 Prestar Libro a Usuario</h3>
            <form method="POST" class="form-loan">
                <select name="libro_id" required>
                    <option value="">-- Selecciona un libro con stock --</option>
                    <?php while ($ld = $librosDisponibles->fetch_assoc()): ?>
                        <option value="<?= $ld['id'] ?>">
                            <?= htmlspecialchars($ld['titulo']) ?> - <?= htmlspecialchars($ld['autor']) ?> (<?= $ld['copias_disponibles'] ?> disp.)
                        </option>
                    <?php endwhile; ?>
                </select>

                <select name="usuario_id" required>
                    <option value="">-- Selecciona usuario --</option>
                    <?php while ($u = $usuarios->fetch_assoc()): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="prestar" class="btn primary">Registrar Préstamo</button>
            </form>
        </section>

        <!-- 2. PRÉSTAMOS ACTIVOS -->
        <section class="card">
            <h3>📋 Préstamos Activos</h3>
            <?php if ($prestamosActivos->num_rows === 0): ?>
                <p class="empty-msg">No hay ejemplares prestados actualmente.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Usuario</th>
                            <th>Fecha de préstamo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pa = $prestamosActivos->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($pa['titulo']) ?></strong> (<?= htmlspecialchars($pa['autor']) ?>)</td>
                            <td>👤 <?= htmlspecialchars($pa['username']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pa['fecha_prestamo'])) ?></td>
                            <td>
                                <a href="?devolver=<?= $pa['id'] ?>" class="btn success small">Registrar Devolución</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <!-- 3. AÑADIR / EDITAR LIBRO -->
        <section class="card">
            <h3><?= $libroEditar ? '✏️ Editar Libro' : '➕ Añadir Nuevo Libro' ?></h3>
            <form method="POST" class="form-grid">
                <input type="hidden" name="id" value="<?= $libroEditar['id'] ?? '' ?>">

                <input type="text" name="titulo" placeholder="Título del libro" required
                       value="<?= htmlspecialchars($libroEditar['titulo'] ?? '') ?>">

                <input type="text" name="autor" placeholder="Autor" required
                       value="<?= htmlspecialchars($libroEditar['autor'] ?? '') ?>">

                <input type="number" name="anio" placeholder="Año" min="1000" max="2099" required
                       value="<?= htmlspecialchars($libroEditar['anio'] ?? date('Y')) ?>">

                <input type="number" name="total_copias" placeholder="Copias" min="1" max="999" required
                       title="Número total de ejemplares"
                       value="<?= htmlspecialchars($libroEditar['total_copias'] ?? 1) ?>">

                <div class="form-actions">
                    <button type="submit" name="guardar_libro" class="btn primary">
                        <?= $libroEditar ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($libroEditar): ?>
                        <a href="index.php" class="btn secondary">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <!-- 4. CATÁLOGO COMPLETO -->
        <section class="card">
            <h3>📖 Gestión del Catálogo</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Año</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $libros->fetch_assoc()): ?>
                    <tr>
                        <td><?= $fila['id'] ?></td>
                        <td><strong><?= htmlspecialchars($fila['titulo']) ?></strong></td>
                        <td><?= htmlspecialchars($fila['autor']) ?></td>
                        <td><?= $fila['anio'] ?></td>
                        <td>
                            <?php if ($fila['copias_disponibles'] > 0): ?>
                                <span class="badge disponible">
                                    <?= $fila['copias_disponibles'] ?> / <?= $fila['total_copias'] ?> disponibles
                                </span>
                            <?php else: ?>
                                <span class="badge agotado">
                                    0 / <?= $fila['total_copias'] ?> (Agotado)
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="?editar=<?= $fila['id'] ?>" class="btn warning small">Editar</a>
                            <a href="?borrar=<?= $fila['id'] ?>" class="btn danger small"
                               onclick="return confirm('¿Seguro que quieres borrar este libro y todos sus ejemplares?')">Borrar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

    <?php else: ?>
        <!-- ==================== VISTA USUARIO LECTOR ==================== -->

        <!-- 1. MIS LIBROS PRESTADOS -->
        <section class="card">
            <h3>🎒 Mis Libros en Préstamo</h3>
            <?php if ($resultadoMisPrestamos->num_rows === 0): ?>
                <p class="empty-msg">Actualmente no tienes ningún libro prestado.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Año</th>
                            <th>Fecha de préstamo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($mp = $resultadoMisPrestamos->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($mp['titulo']) ?></strong></td>
                            <td><?= htmlspecialchars($mp['autor']) ?></td>
                            <td><?= $mp['anio'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($mp['fecha_prestamo'])) ?></td>
                            <td>
                                <a href="?devolver=<?= $mp['id'] ?>" class="btn warning small">Devolver libro</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <!-- 2. CATÁLOGO DISPONIBLE -->
        <section class="card">
            <h3>📚 Catálogo de Libros</h3>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Año</th>
                        <th>Ejemplares</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $libros->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($fila['titulo']) ?></strong></td>
                        <td><?= htmlspecialchars($fila['autor']) ?></td>
                        <td><?= $fila['anio'] ?></td>
                        <td>
                            <?php if ($fila['copias_disponibles'] > 0): ?>
                                <span class="badge disponible">
                                    <?= $fila['copias_disponibles'] ?> de <?= $fila['total_copias'] ?> disp.
                                </span>
                            <?php else: ?>
                                <span class="badge agotado">Agotado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($fila['copias_disponibles'] > 0): ?>
                                <form method="POST" style="margin:0;">
                                    <input type="hidden" name="libro_id" value="<?= $fila['id'] ?>">
                                    <button type="submit" name="prestar" class="btn primary small">Pedir prestado</button>
                                </form>
                            <?php else: ?>
                                <span class="muted">Sin stock</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

    <?php endif; ?>

</main>

</body>
</html>