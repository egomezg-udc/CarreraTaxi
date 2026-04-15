<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use TaxiApp\Carrera\Infrastructure\Persistence\PdoCarreraRepository;
use TaxiApp\Carrera\Application\ListCarrerasUseCase;
use TaxiApp\Carrera\Application\DeleteCarreraUseCase;

$repository     = new PdoCarreraRepository($pdo);
$listUseCase    = new ListCarrerasUseCase($repository);
$deleteUseCase  = new DeleteCarreraUseCase($repository);

if (isset($_GET['delete'])) {
    $deleteUseCase->execute((int) $_GET['delete']);
    header('Location: index.php');
    exit;
}

$carreras = $listUseCase->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Carreras - CarreraTaxi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        h1 { color: #1a1a2e; font-size: 1.5rem; }
        .btn-new { background: #e94560; color: white; padding: 0.6rem 1.4rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a1a2e; color: white; padding: 0.8rem 1rem; text-align: left; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 0.75rem 1rem; border-bottom: 1px solid #f0f0f0; font-size: 0.88rem; }
        tr:hover td { background: #fafbff; }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; }
        .badge-blue  { background: #dbeafe; color: #1e40af; }
        .badge-green { background: #dcfce7; color: #166534; }
        .actions { display: flex; gap: 0.5rem; }
        .btn-edit   { background: #3b82f6; color: white; padding: 0.3rem 0.7rem; border-radius: 5px; text-decoration: none; font-size: 0.78rem; }
        .btn-delete { background: #ef4444; color: white; padding: 0.3rem 0.7rem; border-radius: 5px; text-decoration: none; font-size: 0.78rem; }
        .btn-edit:hover   { background: #2563eb; }
        .btn-delete:hover { background: #dc2626; }
        .empty { text-align: center; padding: 3rem; color: #999; }
    </style>
</head>
<body>

<div class="header">
    <h1>🚕 Listado de Carreras (<?= count($carreras) ?>)</h1>
    <a href="registrar.php" class="btn-new">+ Nueva Carrera</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Taxi</th>
                <th>Taxista</th>
                <th>Origen → Destino</th>
                <th>Km</th>
                <th>Pasajeros</th>
                <th>Duración</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($carreras)): ?>
            <tr><td colspan="10" class="empty">No hay carreras registradas. <a href="registrar.php">Registrar una</a></td></tr>
        <?php else: ?>
            <?php foreach ($carreras as $c): ?>
            <tr>
                <td><?= $c->id ?></td>
                <td><?= htmlspecialchars($c->cliente) ?></td>
                <td><span class="badge badge-blue"><?= htmlspecialchars($c->taxi) ?></span></td>
                <td><?= htmlspecialchars($c->taxista) ?></td>
                <td><?= htmlspecialchars($c->barrioInicio) ?> → <?= htmlspecialchars($c->barrioLlegada) ?></td>
                <td><?= number_format($c->kilometros, 1) ?> km</td>
                <td><?= $c->cantidadPasajeros ?></td>
                <td><?= $c->duracionMinutos ?> min</td>
                <td><span class="badge badge-green">$<?= number_format($c->precio, 2) ?></span></td>
                <td>
                    <div class="actions">
                        <a href="editar.php?id=<?= $c->id ?>" class="btn-edit">✏️ Editar</a>
                        <a href="index.php?delete=<?= $c->id ?>" class="btn-delete"
                           onclick="return confirm('¿Eliminar carrera #<?= $c->id ?>?')">🗑️ Eliminar</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
