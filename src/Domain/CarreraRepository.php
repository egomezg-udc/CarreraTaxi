<?php
declare(strict_types=1);

namespace TaxiApp\Domain;

/**
 * CAPA DE DOMINIO - Puerto/Interfaz CarreraRepository
 * Contrato que cualquier adaptador de infraestructura debe cumplir (CRUDL).
 */
interface CarreraRepository {
    public function save(Carrera $carrera): void;
    public function findById(int $id): ?Carrera;
    public function update(Carrera $carrera): void;
    public function delete(int $id): void;
    public function findAll(): array;
}
