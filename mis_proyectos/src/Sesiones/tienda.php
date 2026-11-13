<?php
session_start();
$productos = [
1 => ['nombre' => 'Balón de Oro', 'precio' => 99.99],
2 => ['nombre' => 'Camiseta', 'precio' => 29.99],
3 => ['nombre' => 'Bufanda', 'precio' => 14.50],
];
if (!isset($_SESSION['carrito'])) {
$_SESSION['carrito'] = [];
}
if (isset($_GET['add'])) {
$id = (int) $_GET['add'];
if (isset($productos[$id])) {
$_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + 1;
}
header('Location: tienda.php');
exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Tienda</title></head>
<body>
<h1>Tienda</h1>
<ul>
<?php foreach ($productos as $id => $p): ?>
<li>
<?= htmlspecialchars($p['nombre']) ?> —
<?= number_format($p['precio'], 2) ?> €
<a href="tienda.php?add=<?= $id ?>">[Añadir]</a>
</li>
<?php endforeach; ?>
</ul>
<h2>Tu carrito (<?= array_sum($_SESSION['carrito']) ?> items)</h2>
<ul>
<?php
$total = 0;
foreach ($_SESSION['carrito'] as $id => $cant) {
$subtotal = $productos[$id]['precio'] * $cant;
$total += $subtotal;
echo "<li>{$productos[$id]['nombre']} × $cant = " .
number_format($subtotal, 2) . " €</li>";
}
?>
</ul>
<p><strong>Total: <?= number_format($total, 2) ?> €</strong></p>
<a href="vaciar.php">Vaciar carrito</a>
</body>
</html>