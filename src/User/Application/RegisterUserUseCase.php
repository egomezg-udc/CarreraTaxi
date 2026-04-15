<?php
declare(strict_types=1);

namespace TaxiApp\User\Application;

use TaxiApp\User\Domain\User;
use TaxiApp\User\Domain\UserRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Registrar Usuario
 * Valida los datos, hashea el password y persiste el nuevo usuario.
 */
class RegisterUserUseCase {
    public function __construct(private UserRepository $repository) {}

    public function execute(array $data): void {
        // Verificar que el email no esté ya registrado
        if ($this->repository->findByEmail($data['email'])) {
            throw new \InvalidArgumentException("El email ya está registrado.");
        }

        $user = new User(
            null,
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),  // Hash seguro
            $data['rol'] ?? 'taxista'
        );

        $this->repository->save($user);
    }
}
