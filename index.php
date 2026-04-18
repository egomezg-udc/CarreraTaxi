<?php
declare(strict_types=1);

// ===========================================================
// ARCHIVO PRINCIPAL - index.php
// Este es el punto de entrada de mi aplicación (Front Controller).
// Aquí conecto todas las capas de la Arquitectura Hexagonal que usé.
// ===========================================================

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Infrastructure/Connection.php';

use TaxiApp\Infrastructure\PdoCarreraRepository;
use TaxiApp\Application\CreateCarreraUseCase;
use TaxiApp\Application\ListCarrerasUseCase;
use TaxiApp\Application\FindCarreraByIdUseCase;
use TaxiApp\Application\UpdateCarreraUseCase;
use TaxiApp\Application\DeleteCarreraUseCase;

// --- Inicializar conexión e inyectar dependencias ---
// Aquí instancio el repositorio de MySQL y se lo paso a los Casos de Uso.
// Esto es Inyección de Dependencias para que las capas no estén amarradas.
$pdo        = createPdoConnection();
$repository = new PdoCarreraRepository($pdo);

$createUseCase  = new CreateCarreraUseCase($repository);
$listUseCase    = new ListCarrerasUseCase($repository);
$findUseCase    = new FindCarreraByIdUseCase($repository);
$updateUseCase  = new UpdateCarreraUseCase($repository);
$deleteUseCase  = new DeleteCarreraUseCase($repository);

// --- Enrutamiento Simple por acción ---
// Uso un parámetro 'action' en la URL para saber qué quiere hacer el usuario.
$action = $_GET['action'] ?? 'list';
$error  = '';

try {
    if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $createUseCase->execute($_POST);
        header('Location: index.php?action=list');
        exit;
    }

    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $updateUseCase->execute((int) $_POST['id'], $_POST);
        header('Location: index.php?action=list');
        exit;
    }

    if ($action === 'delete' && isset($_GET['id'])) {
        $deleteUseCase->execute((int) $_GET['id']);
        header('Location: index.php?action=list');
        exit;
    }
} catch (\InvalidArgumentException $e) {
    $error = $e->getMessage();
    $action = ($action === 'update') ? 'edit' : 'create';
}

// --- Cargar Vista ---
$carreraParaEditar = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $carreraParaEditar = $findUseCase->execute((int) $_GET['id']);
    if (!$carreraParaEditar) {
        header('Location: index.php?action=list');
        exit;
    }
}

$carreras = ($action === 'list') ? $listUseCase->execute() : [];

require_once __DIR__ . '/views/layout.php';
