<?php
declare(strict_types=1);

namespace TaxiApp\User\Application;

use TaxiApp\User\Domain\User;
use TaxiApp\User\Domain\UserRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Cambiar Contraseña
 * Valida la contraseña actual, hashea la nueva y actualiza.
 */
class ChangePasswordUseCase {
    public function __construct(private UserRepository $repository) {}

    public function execute(int $userId, string $currentPassword, string $newPassword): void {
        $user = $this->repository->findById($userId);

        if (!$user) {
            throw new \InvalidArgumentException("Usuario no encontrado.");
        }

        if (!password_verify($currentPassword, $user->passwordHash)) {
            throw new \InvalidArgumentException("La contraseña actual es incorrecta.");
        }

        if (strlen($newPassword) < 8) {
            throw new \InvalidArgumentException("La nueva contraseña debe tener al menos 8 caracteres.");
        }

        $updated = new User(
            $user->id,
            $user->nombre,
            $user->email,
            password_hash($newPassword, PASSWORD_BCRYPT),
            $user->rol
        );

        $this->repository->update($updated);
    }
}
