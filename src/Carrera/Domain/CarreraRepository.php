<?php
namespace TaxiApp\Carrera\Domain;

interface CarreraRepository {
    public function save(Carrera $carrera): void;
    public function findAll(): array;
    public function delete(int $id): void;
}
