<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Eliminar Carrera
 */
class DeleteCarreraUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(int $id): void {
        $this->repository->delete($id);
    }
}
