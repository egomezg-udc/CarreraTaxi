<?php
declare(strict_types=1);

/**
 * CAPA DE INFRAESTRUCTURA - Gestión de la Conexión
 * 
 * Esta función se encarga de crear el objeto PDO que usaremos en todo el proyecto.
 * Carga la configuración de un archivo externo para que sea más fácil de cambiar.
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
