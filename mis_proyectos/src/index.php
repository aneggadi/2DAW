<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Conexion a MySQL
$host = 'db';
$dbname = 'mi_base_datos';
$username = 'usuario';
$password = 'password';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error critico de conexion: " . $e->getMessage());
}

// 2. Creacion de la tabla
$db->exec("CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// 3. Procesamiento CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
        $stmt = $db->prepare("INSERT INTO productos (nombre, cantidad, precio) VALUES (:nombre, :cantidad, :precio)");
        $stmt->execute([
            ':nombre' => $_POST['nombre'],
            ':cantidad' => $_POST['cantidad'],
            ':precio' => $_POST['precio']
        ]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $stmt = $db->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->execute([':id' => $_POST['id']]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// 4. Obtener datos y calcular estadisticas
$productos = $db->query("SELECT * FROM productos ORDER BY fecha DESC")->fetchAll(PDO::FETCH_ASSOC);

$total_inventario = 0;
$total_articulos = 0;
$mayor_stock = 0;
$producto_estrella = 'N/A';

// Arrays para Chart.js
$nombres_chart = [];
$cantidades_chart = [];
$valores_chart = [];

foreach ($productos as $p) {
    $subtotal = $p['cantidad'] * $p['precio'];
    $total_inventario += $subtotal;
    $total_articulos += $p['cantidad'];
    
    // Preparar datos para las graficas
    $nombres_chart[] = $p['nombre'];
    $cantidades_chart[] = $p['cantidad'];
    $valores_chart[] = $subtotal;

    // Calcular el producto con mas stock
    if ($p['cantidad'] > $mayor_stock) {
        $mayor_stock = $p['cantidad'];
        $producto_estrella = $p['nombre'];
    }
}

$total_referencias = count($productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard ERP | Analiticas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <header class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-slate-100">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Panel de Control de Inventario</h1>
                <p class="text-slate-500 mt-1">Resumen de existencias y valoracion en tiempo real</p>
            </div>
        </header>

        <!-- Seccion de Estadisticas (Tarjetas) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex flex-col justify-center">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Referencias</p>
                <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $total_referencias; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex flex-col justify-center">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Unidades Fisicas</p>
                <p class="text-3xl font-bold text-emerald-600 mt-2"><?php echo $total_articulos; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex flex-col justify-center">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Valor Monetario Total</p>
                <p class="text-3xl font-bold text-indigo-600 mt-2"><?php echo number_format($total_inventario, 2); ?> €</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex flex-col justify-center">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Mayor Stock</p>
                <p class="text-xl font-bold text-amber-600 mt-2 truncate" title="<?php echo $producto_estrella; ?>">
                    <?php echo $producto_estrella; ?> <span class="text-sm text-slate-400">(<?php echo $mayor_stock; ?>)</span>
                </p>
            </div>
        </div>

        <!-- Seccion de Graficas -->
        <?php if ($total_referencias > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold mb-4 text-slate-700">Stock por Producto</h3>
                <canvas id="graficaStock" class="max-h-64"></canvas>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold mb-4 text-slate-700">Valor Monetario (Distribucion)</h3>
                <canvas id="graficaValor" class="max-h-64"></canvas>
            </div>
        </div>
        <?php endif; ?>

        <!-- Seccion de Operaciones -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulario -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 h-fit">
                <h2 class="text-xl font-bold mb-4 text-slate-800">Nuevo Ingreso</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="accion" value="agregar">
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Nombre</label>
                        <input type="text" name="nombre" required class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Cantidad</label>
                            <input type="number" name="cantidad" required min="1" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Precio</label>
                            <input type="number" name="precio" required min="0.01" step="0.01" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-slate-800 transition shadow-sm">
                        Registrar Producto
                    </button>
                </form>
            </div>

            <!-- Tabla -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold mb-4 text-slate-800">Inventario Detallado</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-slate-200 text-slate-500 text-sm uppercase tracking-wide">
                                <th class="p-3">Ref</th>
                                <th class="p-3">Articulo</th>
                                <th class="p-3">Unidades</th>
                                <th class="p-3">Precio</th>
                                <th class="p-3">Total</th>
                                <th class="p-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($productos)): ?>
                                <tr><td colspan="6" class="p-6 text-center text-slate-400">Base de datos vacia. Ingresa tu primer producto.</td></tr>
                            <?php else: ?>
                                <?php foreach ($productos as $p): ?>
                                    <tr class="hover:bg-slate-50 transition duration-150">
                                        <td class="p-3 text-slate-400 text-sm">#<?php echo $p['id']; ?></td>
                                        <td class="p-3 font-semibold text-slate-700"><?php echo htmlspecialchars($p['nombre']); ?></td>
                                        <td class="p-3">
                                            <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-md text-xs font-bold border border-blue-100">
                                                <?php echo $p['cantidad']; ?>
                                            </span>
                                        </td>
                                        <td class="p-3 text-slate-600"><?php echo number_format($p['precio'], 2); ?> €</td>
                                        <td class="p-3 font-bold text-slate-800"><?php echo number_format($p['cantidad'] * $p['precio'], 2); ?> €</td>
                                        <td class="p-3 text-right">
                                            <form method="POST" class="inline" onsubmit="return confirm('Seguro que deseas eliminar esto?');">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                                <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para renderizar las graficas con Chart.js -->
    <script>
        <?php if ($total_referencias > 0): ?>
        const nombres = <?php echo json_encode($nombres_chart); ?>;
        const cantidades = <?php echo json_encode($cantidades_chart); ?>;
        const valores = <?php echo json_encode($valores_chart); ?>;

        // Grafica de Barras - Stock
        new Chart(document.getElementById('graficaStock'), {
            type: 'bar',
            data: {
                labels: nombres,
                datasets: [{
                    label: 'Unidades en Stock',
                    data: cantidades,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Grafica Doughnut - Valor Monetario
        new Chart(document.getElementById('graficaValor'), {
            type: 'doughnut',
            data: {
                labels: nombres,
                datasets: [{
                    label: 'Valor Total (€)',
                    data: valores,
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(139, 92, 246, 0.7)'
                    ],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        <?php endif; ?>
    </script>
</body>
</html>