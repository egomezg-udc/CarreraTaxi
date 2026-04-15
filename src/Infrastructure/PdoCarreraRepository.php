<?php
declare(strict_types=1);

namespace TaxiApp\Infrastructure;

use PDO;
use TaxiApp\Domain\Carrera;
use TaxiApp\Domain\CarreraRepository;

/**
 * CAPA DE INFRAESTRUCTURA - Adaptador MySQL con PDO
 * Implementa el contrato definido por el puerto CarreraRepository.
 */
class PdoCarreraRepository implements CarreraRepository {
    public function __construct(private PDO $pdo) {}

    private function hydrate(array $row): Carrera {
        return new Carrera(
            (int) $row['id'],
            $row['cliente'],
            $row['taxi'],
            (float) $row['kilometros'],
            $row['barrioInicio'],
            $row['barrioLlegada'],
            (int) $row['cantidadPasajeros'],
            $row['taxista'],
            (float) $row['precio'],
            (int) $row['duracionMinutos']
        );
    }

    public function save(Carrera $carrera): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO carreras 
                (cliente, taxi, kilometros, barrioInicio, barrioLlegada, cantidadPasajeros, taxista, precio, duracionMinutos)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $carrera->getCliente(), $carrera->getTaxi(), $carrera->getKilometros(),
            $carrera->getBarrioInicio(), $carrera->getBarrioLlegada(),
            $carrera->getCantidadPasajeros(), $carrera->getTaxista(),
            $carrera->getPrecio(), $carrera->getDuracionMinutos()
        ]);
    }

    public function findById(int $id): ?Carrera {
        $stmt = $this->pdo->prepare("SELECT * FROM carreras WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function update(Carrera $carrera): void {
        $stmt = $this->pdo->prepare("
            UPDATE carreras SET 
                cliente=?, taxi=?, kilometros=?, barrioInicio=?, barrioLlegada=?,
                cantidadPasajeros=?, taxista=?, precio=?, duracionMinutos=?
            WHERE id=?
        ");
        $stmt->execute([
            $carrera->getCliente(), $carrera->getTaxi(), $carrera->getKilometros(),
            $carrera->getBarrioInicio(), $carrera->getBarrioLlegada(),
            $carrera->getCantidadPasajeros(), $carrera->getTaxista(),
            $carrera->getPrecio(), $carrera->getDuracionMinutos(),
            $carrera->getId()
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM carreras WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM carreras ORDER BY id DESC");
        $carreras = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $carreras[] = $this->hydrate($row);
        }
        return $carreras;
    }
}
