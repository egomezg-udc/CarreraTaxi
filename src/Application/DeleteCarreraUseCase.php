<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Eliminar
 * 
 * Aquí manejamos el borrar una carrera. Le pasamos el ID que viene del GET
 * al repositorio para que haga la limpieza en la base de datos.
 */
class DeleteCarreraUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(int $id): void {
        $this->repository->delete($id);
    }
}
