<?php
declare(strict_types=1);

namespace TaxiApp\User\Application;

use TaxiApp\User\Domain\User;
use TaxiApp\User\Domain\UserRepository;

/**
 * CAPA DE APLICACIÓN - AuthService
 * Gestiona autenticación y sesiones PHP.
 * 
 * Responsabilidades:
 *  - Verificar credenciales (email + password)
 *  - Iniciar/cerrar sesión
 *  - Comprobar si hay una sesión activa
 */
class AuthService {
    public function __construct(private UserRepository $repository) {}

    /**
     * Intenta autenticar al usuario con email y contraseña.
     * Retorna true si las credenciales son válidas, false en caso contrario.
     */
    public function login(string $email, string $password): bool {
        $user = $this->repository->findByEmail($email);

        if (!$user) {
            return false;
        }

        // Verificamos el password contra el hash almacenado (bcrypt)
        if (!password_verify($password, $user->passwordHash)) {
            return false;
        }

        // Iniciamos la sesión PHP guardando los datos del usuario
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_nombre']= $user->nombre;
        $_SESSION['user_rol']   = $user->rol;

        return true;
    }

    /**
     * Cierra la sesión activa del usuario.
     */
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Verifica si hay un usuario autenticado en la sesión actual.
     */
    public function isAuthenticated(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    /**
     * Retorna los datos del usuario autenticado o null si no hay sesión.
     */
    public function getCurrentUser(): ?array {
        if (!$this->isAuthenticated()) {
            return null;
        }
        return [
            'id'     => $_SESSION['user_id'],
            'email'  => $_SESSION['user_email'],
            'nombre' => $_SESSION['user_nombre'],
            'rol'    => $_SESSION['user_rol'],
        ];
    }
}
