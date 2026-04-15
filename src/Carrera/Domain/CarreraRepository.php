<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Domain;

interface CarreraRepository {
    public function save(Carrera $carrera): void;
    public function findAll(): array;
    public function findById(int $id): ?Carrera;
    public function update(Carrera $carrera): void;
    public function delete(int $id): void;
}
