<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use TaxiApp\User\Infrastructure\Persistence\PdoUserRepository;
use TaxiApp\User\Application\AuthService;

$repository  = new PdoUserRepository($pdo);
$authService = new AuthService($repository);

// Si ya está autenticado, redirigir al inicio
if ($authService->isAuthenticated()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($authService->login($email, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Correo electrónico o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - CarreraTaxi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: white; border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            padding: 2.5rem; width: 100%; max-width: 420px;
        }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo span { font-size: 3rem; display: block; }
        .logo h1 { color: #1a1a2e; font-size: 1.5rem; margin-top: 0.5rem; }
        .logo p { color: #888; font-size: 0.85rem; margin-top: 0.3rem; }

        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-size: 0.82rem; font-weight: 600; color: #555; margin-bottom: 0.4rem; }
        input {
            width: 100%; padding: 0.7rem 1rem; border: 1.5px solid #e0e0e0;
            border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;
        }
        input:focus { outline: none; border-color: #0f3460; box-shadow: 0 0 0 3px rgba(15,52,96,0.1); }

        .btn {
            width: 100%; padding: 0.85rem;
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            color: white; border: none; border-radius: 8px;
            font-size: 1rem; font-weight: 600; cursor: pointer; transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.9; }

        .alert-error {
            background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444;
            padding: 0.8rem 1rem; border-radius: 6px; margin-bottom: 1.2rem; font-size: 0.88rem;
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="logo">
        <span>🚕</span>
        <h1>CarreraTaxi</h1>
        <p>Sistema de Gestión de Carreras</p>
    </div>

    <?php if ($error): ?>
        <div class="alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   required placeholder="usuario@correo.com" autofocus>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn" id="btn-login">Iniciar Sesión</button>
    </form>
</div>
</body>
</html>
