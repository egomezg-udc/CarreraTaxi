<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Application;

use TaxiApp\Carrera\Domain\Carrera;
use TaxiApp\Carrera\Domain\CarreraRepository;

class FindCarreraByIdUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(int $id): ?Carrera {
        return $this->repository->findById($id);
    }
}
