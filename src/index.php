<?php
$dsn = "mysql:host=db;dbname=demo;charset=utf8mb4";
$user = "dwes";
$pass = "dwes";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Crear tabla si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS visitas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(45),
        ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Operaciones CRUD
    $action = $_GET['action'] ?? 'list';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            $pdo->prepare("DELETE FROM visitas WHERE id = ?")->execute([$_POST['id']]);
        } elseif (isset($_POST['add'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $pdo->prepare("INSERT INTO visitas (ip) VALUES (?)")->execute([$ip]);
        }
    }

    $visitas = $pdo->query("SELECT * FROM visitas ORDER BY ts DESC")->fetchAll(PDO::FETCH_ASSOC);
    $count = count($visitas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Visitas - CRUD</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Gestor de Visitas</h1>
    <p>Total de visitas: <strong><?= $count ?></strong></p>

    <form method="POST">
        <button type="submit" name="add">Registrar Nueva Visita</button>
    </form>

    <h2>Listado de Visitas</h2>
    <table>
        <tr><th>ID</th><th>IP</th><th>Fecha y Hora</th><th>Acción</th></tr>
        <?php foreach ($visitas as $v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= htmlspecialchars($v['ip']) ?></td>
            <td><?= $v['ts'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $v['id'] ?>">
                    <button type="submit" name="delete" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php
} catch (Throwable $e) {
    echo "<h1>Error</h1><pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
?>