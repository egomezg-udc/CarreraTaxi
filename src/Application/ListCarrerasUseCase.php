<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Listar Carreras
 */
class ListCarrerasUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(): array {
        return $this->repository->findAll();
    }
}
