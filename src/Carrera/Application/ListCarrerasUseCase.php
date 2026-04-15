<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Application;

use TaxiApp\Carrera\Domain\CarreraRepository;

class ListCarrerasUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(): array {
        return $this->repository->findAll();
    }
}
