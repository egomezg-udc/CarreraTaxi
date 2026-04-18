<?php
declare(strict_types=1);

namespace TaxiApp\Domain;

/**
 * CAPA DE DOMINIO - Entidad Carrera
 * 
 * Aquí definí la entidad principal del sistema. En esta capa no puse nada de la base de datos
 * ni de librerías externas, solo la lógica de lo que es una "Carrera" en nuestro negocio.
 */
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
        // Al crear el objeto, validamos enseguida que los datos tengan sentido
        $this->validar();
    }

    private function validar(): void {
        if ($this->kilometros <= 0) {
            throw new \InvalidArgumentException("Los kilómetros deben ser mayores a cero.");
        }
        if ($this->cantidadPasajeros <= 0 || $this->cantidadPasajeros > 6) {
            throw new \InvalidArgumentException("Cantidad de pasajeros no permitida (1-6).");
        }
        if ($this->precio < 0) {
            throw new \InvalidArgumentException("El precio no puede ser negativo.");
        }
        if ($this->duracionMinutos <= 0) {
            throw new \InvalidArgumentException("La duración debe ser mayor a cero.");
        }
    }

    public function getId(): ?int { return $this->id; }
    public function getCliente(): string { return $this->cliente; }
    public function getTaxi(): string { return $this->taxi; }
    public function getKilometros(): float { return $this->kilometros; }
    public function getBarrioInicio(): string { return $this->barrioInicio; }
    public function getBarrioLlegada(): string { return $this->barrioLlegada; }
    public function getCantidadPasajeros(): int { return $this->cantidadPasajeros; }
    public function getTaxista(): string { return $this->taxista; }
    public function getPrecio(): float { return $this->precio; }
    public function getDuracionMinutos(): int { return $this->duracionMinutos; }
}
