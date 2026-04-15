<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use TaxiApp\Carrera\Infrastructure\Persistence\PdoCarreraRepository;
use TaxiApp\Carrera\Application\FindCarreraByIdUseCase;
use TaxiApp\Carrera\Application\UpdateCarreraUseCase;

$repository    = new PdoCarreraRepository($pdo);
$findUseCase   = new FindCarreraByIdUseCase($repository);
$updateUseCase = new UpdateCarreraUseCase($repository);

$id      = (int) ($_GET['id'] ?? 0);
$carrera = $findUseCase->execute($id);

if (!$carrera) {
    header('Location: index.php');
    exit;
}

$mensaje = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $updateUseCase->execute($id, $_POST);
        $mensaje = '✅ Carrera actualizada exitosamente.';
        $carrera = $findUseCase->execute($id);
    } catch (\Exception $e) {
        $error = '❌ ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Carrera #<?= $id ?> - CarreraTaxi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding: 2rem; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); padding: 2rem; width: 100%; max-width: 620px; }
        h1 { color: #1a1a2e; margin-bottom: 1.5rem; font-size: 1.4rem; border-bottom: 3px solid #3b82f6; padding-bottom: 0.5rem; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.3rem; }
        .full { grid-column: 1 / -1; }
        label { font-size: 0.82rem; font-weight: 600; color: #555; }
        input { padding: 0.55rem 0.8rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; }
        input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
        .btn { background: #3b82f6; color: white; padding: 0.8rem; border: none; border-radius: 6px; width: 100%; font-size: 1rem; cursor: pointer; margin-top: 1rem; }
        .btn:hover { background: #2563eb; }
        .link { display: block; text-align: center; margin-top: 1rem; color: #3b82f6; font-size: 0.9rem; text-decoration: none; }
        .alert { padding: 0.8rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; }
        .alert-success { background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
    </style>
</head>
<body>
<div class="card">
    <h1>✏️ Editar Carrera #<?= $id ?></h1>

    <?php if ($mensaje): ?><div class="alert alert-success"><?= $mensaje ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="POST" action="">
        <div class="form-grid">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input type="text" id="cliente" name="cliente" value="<?= htmlspecialchars($carrera->cliente) ?>" required>
            </div>
            <div class="form-group">
                <label for="taxi">Placa del Taxi</label>
                <input type="text" id="taxi" name="taxi" value="<?= htmlspecialchars($carrera->taxi) ?>" required>
            </div>
            <div class="form-group">
                <label for="taxista">Taxista</label>
                <input type="text" id="taxista" name="taxista" value="<?= htmlspecialchars($carrera->taxista) ?>" required>
            </div>
            <div class="form-group">
                <label for="cantidadPasajeros">Pasajeros (1-6)</label>
                <input type="number" id="cantidadPasajeros" name="cantidadPasajeros" value="<?= $carrera->cantidadPasajeros ?>" min="1" max="6" required>
            </div>
            <div class="form-group">
                <label for="barrioInicio">Barrio de Inicio</label>
                <input type="text" id="barrioInicio" name="barrioInicio" value="<?= htmlspecialchars($carrera->barrioInicio) ?>" required>
            </div>
            <div class="form-group">
                <label for="barrioLlegada">Barrio de Llegada</label>
                <input type="text" id="barrioLlegada" name="barrioLlegada" value="<?= htmlspecialchars($carrera->barrioLlegada) ?>" required>
            </div>
            <div class="form-group">
                <label for="kilometros">Kilómetros</label>
                <input type="number" id="kilometros" name="kilometros" step="0.1" min="0.1" value="<?= $carrera->kilometros ?>" required>
            </div>
            <div class="form-group">
                <label for="duracionMinutos">Duración (minutos)</label>
                <input type="number" id="duracionMinutos" name="duracionMinutos" min="1" value="<?= $carrera->duracionMinutos ?>" required>
            </div>
            <div class="form-group full">
                <label for="precio">Precio ($)</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" value="<?= $carrera->precio ?>" required>
            </div>
        </div>
        <button type="submit" class="btn">Actualizar Carrera</button>
    </form>
    <a href="index.php" class="link">← Volver al listado</a>
</div>
</body>
</html>
