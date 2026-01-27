<?php
$dsn = "mysql:host=db;dbname=demo;charset=utf8mb4";
$user = "dwes";
$pass = "dwes";
try {
 // Conexión a la BD
 $pdo = new PDO($dsn, $user, $pass, [
 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
 ]);
 // Crear tabla si no existe
 $pdo->exec("CREATE TABLE IF NOT EXISTS visitas (
 id INT AUTO_INCREMENT PRIMARY KEY,
 ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 )");
 // Insertar un registro nuevo
 $pdo->exec("INSERT INTO visitas () VALUES ()");
 // Contar registros
 $count = $pdo->query("SELECT COUNT(*) FROM visitas")->fetchColumn();
 echo "<h1>Proyecto funcionando</h1>";
 echo "<p>Conexión a MySQL establecida.</p>";
 echo "<p>Total de visitas registradas: <strong>$count</strong></p>";
} catch (Throwable $e) {
 echo "<h1>Error al conectar a MySQL</h1>";
 echo "<pre>" . $e->getMessage() . "</pre>";
}
?>