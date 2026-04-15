<?php
declare(strict_types=1);

namespace TaxiApp\Domain;

/**
 * Capa de Dominio: Puerto (Interface)
 * Define el contrato que cualquier adaptador de infraestructura debe cumplir.
 */
interface CarreraRepository {
    public function save(Carrera $carrera): void;
    public function findById(int $id): ?Carrera;
    public function update(Carrera $carrera): void;
    public function delete(int $id): void;
    public function findAll(): array;
}
