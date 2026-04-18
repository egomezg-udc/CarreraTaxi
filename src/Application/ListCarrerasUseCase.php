<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Listar
 * 
 * Este caso de uso es sencillo, solo le pide al repositorio que nos traiga
 * todas las carreras registradas para mostrarlas en la tabla.
 */
class ListCarrerasUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(): array {
        return $this->repository->findAll();
    }
}
