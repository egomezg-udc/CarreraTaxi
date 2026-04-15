<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\Carrera;
use TaxiApp\Domain\CarreraRepository;

/**
 * Capa de Aplicación: Caso de Uso
 * Orquesta la lógica de negocio necesaria para crear una carrera.
 */
class CreateCarreraUseCase {
    public function __construct(
        private CarreraRepository $repository
    ) {}

    public function execute(array $data): void {
        $carrera = new Carrera(
            null, // El ID lo generará la BD
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

        $this->repository->save($carrera);
    }
}
