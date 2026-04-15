<?php
declare(strict_types=1);

namespace TaxiApp\Domain;

/**
 * Capa de Dominio: Entidad Carrera
 * Representa el corazón del negocio con sus reglas y datos.
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
    }

    // Getters
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

    public function toArray(): array {
        return [
            'id' => $this->id,
            'cliente' => $this->cliente,
            'taxi' => $this->taxi,
            'kilometros' => $this->kilometros,
            'barrioInicio' => $this->barrioInicio,
            'barrioLlegada' => $this->barrioLlegada,
            'cantidadPasajeros' => $this->cantidadPasajeros,
            'taxista' => $this->taxista,
            'precio' => $this->precio,
            'duracionMinutos' => $this->duracionMinutos
        ];
    }
}
