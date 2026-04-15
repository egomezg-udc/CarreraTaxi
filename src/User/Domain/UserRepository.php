<?php
declare(strict_types=1);

namespace TaxiApp\User\Domain;

/**
 * CAPA DE DOMINIO - Puerto UserRepository
 * Contrato que define cómo persistir y recuperar usuarios.
 */
interface UserRepository {
    public function save(User $user): void;
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function findAll(): array;
    public function update(User $user): void;
    public function delete(int $id): void;
}
