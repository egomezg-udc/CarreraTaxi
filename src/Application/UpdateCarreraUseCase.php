<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\Carrera;
use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Actualizar Carrera
 */
class UpdateCarreraUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(int $id, array $data): void {
        $carrera = new Carrera(
            $id,
            $data['cliente'],
            $data['taxi'],
            (float) $data['kilometros'],
            $data['barrioInicio'],
            $data['barrioLlegada'],
            (int) $data['cantidadPasajeros'],
            $data['taxista'],
            (float) $data['precio'],
            (int) $data['duracionMinutos']
        );
        $this->repository->update($carrera);
    }
}
