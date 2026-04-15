<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Application;

use TaxiApp\Carrera\Domain\CarreraRepository;

class DeleteCarreraUseCase {
    public function __construct(private CarreraRepository $repository) {}

    public function execute(int $id): void {
        $this->repository->delete($id);
    }
}
