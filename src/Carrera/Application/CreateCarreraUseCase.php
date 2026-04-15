<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Application;

use TaxiApp\Carrera\Domain\Carrera;
use TaxiApp\Carrera\Domain\CarreraRepository;

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
