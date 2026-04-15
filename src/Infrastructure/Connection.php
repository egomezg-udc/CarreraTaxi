<?php
declare(strict_types=1);

/**
 * CAPA DE INFRAESTRUCTURA - Fábrica de Conexión PDO
 * Crea y retorna la conexión a MySQL configurada con PDO.
 */
function createPdoConnection(): PDO {
    $config = require __DIR__ . '/db_config.php';

    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    return $pdo;
}
