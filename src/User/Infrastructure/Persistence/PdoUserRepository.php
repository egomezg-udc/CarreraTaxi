<?php
declare(strict_types=1);

namespace TaxiApp\User\Infrastructure\Persistence;

use PDO;
use TaxiApp\User\Domain\User;
use TaxiApp\User\Domain\UserRepository;

/**
 * CAPA DE INFRAESTRUCTURA - Adaptador MySQL con PDO
 * Implementa el contrato UserRepository usando PDO.
 */
class PdoUserRepository implements UserRepository {
    public function __construct(private PDO $connection) {}

    private function hydrate(array $row): User {
        return new User(
            (int)  $row['id'],
                   $row['nombre'],
                   $row['email'],
                   $row['password_hash'],
                   $row['rol']
        );
    }

    public function save(User $user): void {
        $stmt = $this->connection->prepare("
            INSERT INTO users (nombre, email, password_hash, rol)
            VALUES (:nombre, :email, :password_hash, :rol)
        ");
        $stmt->execute([
            'nombre'        => $user->nombre,
            'email'         => $user->email,
            'password_hash' => $user->passwordHash,
            'rol'           => $user->rol,
        ]);
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function findById(int $id): ?User {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function findAll(): array {
        $stmt = $this->connection->query("SELECT * FROM users ORDER BY id DESC");
        return array_map(fn($row) => $this->hydrate($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function update(User $user): void {
        $stmt = $this->connection->prepare("
            UPDATE users SET nombre=:nombre, email=:email, password_hash=:password_hash, rol=:rol
            WHERE id=:id
        ");
        $stmt->execute([
            'id'            => $user->id,
            'nombre'        => $user->nombre,
            'email'         => $user->email,
            'password_hash' => $user->passwordHash,
            'rol'           => $user->rol,
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
