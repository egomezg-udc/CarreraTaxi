<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use TaxiApp\User\Infrastructure\Persistence\PdoUserRepository;
use TaxiApp\User\Infrastructure\Mail\FileEmailAdapter;
use TaxiApp\User\Application\PasswordRecoveryUseCase;

$repository  = new PdoUserRepository($pdo);
$emailSender = new FileEmailAdapter(__DIR__ . '/logs/emails');
$useCase     = new PasswordRecoveryUseCase($repository, $emailSender);

$mensaje = '';
$error   = '';

// URL base de la aplicación (ajustar si es necesario)
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Por favor ingresa tu correo electrónico.';
    } else {
        // Ejecutamos el caso de uso (no revelamos si el email existe)
        $useCase->execute($email, $baseUrl);
        $mensaje = "Si el correo <strong>{$email}</strong> está registrado, recibirás las instrucciones en breve.
                    <br><small>(En modo desarrollo, revisa la carpeta <code>logs/emails/</code>)</small>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - CarreraTaxi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;
        }
        .card {
            background: white; border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            padding: 2.5rem; width: 100%; max-width: 420px;
        }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo span { font-size: 2.5rem; display: block; }
        .logo h1 { color: #1a1a2e; font-size: 1.3rem; margin-top: 0.5rem; }
        .logo p  { color: #888; font-size: 0.82rem; margin-top: 0.3rem; }

        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-size: 0.82rem; font-weight: 600; color: #555; margin-bottom: 0.4rem; }
        input {
            width: 100%; padding: 0.7rem 1rem;
            border: 1.5px solid #e0e0e0; border-radius: 8px; font-size: 0.9rem;
        }
        input:focus { outline: none; border-color: #0f3460; box-shadow: 0 0 0 3px rgba(15,52,96,0.1); }

        .btn {
            width: 100%; padding: 0.85rem;
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            color: white; border: none; border-radius: 8px;
            font-size: 1rem; font-weight: 600; cursor: pointer;
        }
        .btn:hover { opacity: 0.9; }
        .back-link { display: block; text-align: center; margin-top: 1rem; color: #3b82f6; font-size: 0.88rem; text-decoration: none; }
        .alert { padding: 0.9rem 1rem; border-radius: 6px; margin-bottom: 1.2rem; font-size: 0.88rem; line-height: 1.5; }
        .alert-success { background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        code { background: #f0f0f0; padding: 0.1em 0.4em; border-radius: 4px; font-size: 0.82rem; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <span>🔐</span>
        <h1>¿Olvidaste tu contraseña?</h1>
        <p>Ingresa tu correo para recibir instrucciones</p>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-success">✅ <?= $mensaje ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!$mensaje): ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   required placeholder="tucorreo@ejemplo.com" autofocus>
        </div>
        <button type="submit" class="btn" id="btn-recuperar">Enviar Instrucciones</button>
    </form>
    <?php endif; ?>

    <a href="login.php" class="back-link">← Volver al inicio de sesión</a>
</div>
</body>
</html>
