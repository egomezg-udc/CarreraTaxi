<?php
namespace TaxiApp\Carrera\Domain;

class Carrera {
    public function __construct(
        private ?int $id,
        private string $cliente,
        private string $taxi,
        private float $kilometros,
        private string $barrioInicio,
        private string $barrioLlegada,
        private int $cantidadPasajeros,
        private string $taxista,
        private float $precio,
        private int $duracionMinutos
    ) {
        // Validación de negocio: No puede haber carreras de 0 km
        if ($this->kilometros <= 0) {
            throw new \Exception("Los kilómetros deben ser mayores a cero.");
        }
    }

    // Getters necesarios para la persistencia
    public function toArray(): array {
        return get_object_vars($this);
    }
}
