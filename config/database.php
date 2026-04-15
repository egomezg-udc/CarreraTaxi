<?php
declare(strict_types=1);

// =============================================
// CONFIGURACIÓN DE BASE DE DATOS
// =============================================
$host     = 'localhost';
$dbname   = 'ingenieria_software_carreras_taxi';
$user     = 'root';       // <-- cambia por tu usuario MySQL
$password = '';           // <-- cambia por tu contraseña MySQL
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (\PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
