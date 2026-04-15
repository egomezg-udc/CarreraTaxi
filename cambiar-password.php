<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use TaxiApp\User\Infrastructure\Persistence\PdoUserRepository;
use TaxiApp\User\Application\AuthService;
use TaxiApp\User\Application\ChangePasswordUseCase;

$repository        = new PdoUserRepository($pdo);
$authService       = new AuthService($repository);
$changePasswordUC  = new ChangePasswordUseCase($repository);

// Redirigir si no está autenticado
if (!$authService->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$currentUser = $authService->getCurrentUser();
$mensaje     = '';
$error       = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $changePasswordUC->execute(
            (int) $currentUser['id'],
            $_POST['password_actual'] ?? '',
            $_POST['password_nuevo']  ?? ''
        );
        $mensaje = '✅ Contraseña actualizada correctamente.';
    } catch (\InvalidArgumentException $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - CarreraTaxi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding: 3rem 1rem; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); padding: 2rem; width: 100%; max-width: 440px; }
        h1 { color: #1a1a2e; margin-bottom: 1.5rem; font-size: 1.3rem; border-bottom: 3px solid #0f3460; padding-bottom: 0.5rem; }
        .user-info { background: #f0f2f5; border-radius: 8px; padding: 0.8rem 1rem; margin-bottom: 1.5rem; font-size: 0.88rem; color: #555; }
        .form-group { margin-bottom: 1.1rem; }
        label { display: block; font-size: 0.82rem; font-weight: 600; color: #555; margin-bottom: 0.4rem; }
        input { width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #e0e0e0; border-radius: 8px; font-size: 0.9rem; }
        input:focus { outline: none; border-color: #0f3460; box-shadow: 0 0 0 3px rgba(15,52,96,0.1); }
        .btn { width: 100%; padding: 0.8rem; background: #1a1a2e; color: white; border: none; border-radius: 8px; font-size: 0.95rem; cursor: pointer; }
        .btn:hover { background: #0f3460; }
        .link { display: block; text-align: center; margin-top: 1rem; color: #3b82f6; font-size: 0.88rem; text-decoration: none; }
        .alert { padding: 0.8rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.88rem; }
        .alert-success { background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        hr { border: none; border-top: 1px solid #eee; margin: 1.5rem 0; }
    </style>
</head>
<body>
<div class="card">
    <h1>🔒 Cambiar Contraseña</h1>

    <div class="user-info">
        👤 <strong><?= htmlspecialchars($currentUser['nombre']) ?></strong>
        — <?= htmlspecialchars($currentUser['email']) ?>
    </div>

    <?php if ($mensaje): ?><div class="alert alert-success"><?= $mensaje ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="password_actual">Contraseña Actual</label>
            <input type="password" id="password_actual" name="password_actual" required placeholder="Ingresa tu contraseña actual">
        </div>
        <div class="form-group">
            <label for="password_nuevo">Nueva Contraseña (mín. 8 caracteres)</label>
            <input type="password" id="password_nuevo" name="password_nuevo" required minlength="8" placeholder="Mínimo 8 caracteres">
        </div>
        <button type="submit" class="btn">Actualizar Contraseña</button>
    </form>
    <hr>
    <a href="index.php" class="link">← Volver al inicio</a>
</div>
</body>
</html>
