<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use TaxiApp\User\Infrastructure\Persistence\PdoUserRepository;
use TaxiApp\User\Application\AuthService;

$authService = new AuthService(new PdoUserRepository($pdo));
$authService->logout();

header('Location: login.php');
exit;
