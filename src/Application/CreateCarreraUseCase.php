<?php
declare(strict_types=1);

namespace TaxiApp\Application;

use TaxiApp\Domain\Carrera;
use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Crear Carrera
 * 
 * En esta capa es donde orquestamos todo. Recibimos los datos de la vista,
 * creamos el objeto de dominio (Carrera) y le decimos al repositorio que lo guarde.
 */
class CreateCarreraUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(array $data): void {
        $carrera = new Carrera(
            null,
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
