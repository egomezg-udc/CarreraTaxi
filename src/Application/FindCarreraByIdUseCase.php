<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\Carrera;
use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Obtener Carrera por ID
 */
class FindCarreraByIdUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(int $id): ?Carrera {
        return $this->repository->findById($id);
    }
}
