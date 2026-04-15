<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Domain;

class Carrera {
    public function __construct(
        public ?int $id,
        public string $cliente,
        public string $taxi,
        public float $kilometros,
        public string $barrioInicio,
        public string $barrioLlegada,
        public int $cantidadPasajeros,
        public string $taxista,
        public float $precio,
        public int $duracionMinutos
    ) {}
}
