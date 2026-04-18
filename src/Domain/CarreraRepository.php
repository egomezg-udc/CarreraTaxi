<?php
declare(strict_types=1);

namespace TaxiApp\Domain;

/**
 * CAPA DE DOMINIO - Puerto (Interfaz)
 * 
 * Esta es la interfaz del repositorio. Aquí solo digo QUÉ operaciones se pueden hacer
 * (guardar, buscar, etc.), pero no digo CÓMO se hacen (si es con MySQL, con archivos, etc.).
 * Es el "puerto" de nuestra arquitectura hexagonal.
 */
interface CarreraRepository {
    public function save(Carrera $carrera): void;
    public function findById(int $id): ?Carrera;
    public function update(Carrera $carrera): void;
    public function delete(int $id): void;
    public function findAll(): array;
}
