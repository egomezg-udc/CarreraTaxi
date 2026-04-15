<?php
declare(strict_types=1);

namespace TaxiApp\User\Domain;

/**
 * CAPA DE DOMINIO - Entidad User
 * Representa a un usuario del sistema (taxista/administrador).
 */
class User {
    public function __construct(
        public ?int    $id,
        public string  $nombre,
        public string  $email,
        public string  $passwordHash,  // Siempre almacenamos el hash, nunca la clave en texto plano
        public string  $rol            // 'admin' | 'taxista'
    ) {}
}
