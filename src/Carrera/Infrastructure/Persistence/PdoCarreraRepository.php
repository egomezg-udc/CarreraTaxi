<?php
declare(strict_types=1);

namespace TaxiApp\Carrera\Infrastructure\Persistence;

use TaxiApp\Carrera\Domain\Carrera;
use TaxiApp\Carrera\Domain\CarreraRepository;
use PDO;

class PdoCarreraRepository implements CarreraRepository {
    public function __construct(private PDO $connection) {}

    public function save(Carrera $carrera): void {
        $sql = "INSERT INTO carreras 
                    (cliente, taxi, kilometros, barrioInicio, barrioLlegada, cantidadPasajeros, taxista, precio, duracionMinutos) 
                VALUES 
                    (:cliente, :taxi, :kilometros, :barrioInicio, :barrioLlegada, :cantidadPasajeros, :taxista, :precio, :duracionMinutos)";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'cliente'           => $carrera->cliente,
            'taxi'              => $carrera->taxi,
            'kilometros'        => $carrera->kilometros,
            'barrioInicio'      => $carrera->barrioInicio,
            'barrioLlegada'     => $carrera->barrioLlegada,
            'cantidadPasajeros' => $carrera->cantidadPasajeros,
            'taxista'           => $carrera->taxista,
            'precio'            => $carrera->precio,
            'duracionMinutos'   => $carrera->duracionMinutos,
        ]);
    }

    public function findAll(): array {
        $stmt = $this->connection->query("SELECT * FROM carreras ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => $this->hydrate($row), $rows);
    }

    public function findById(int $id): ?Carrera {
        $stmt = $this->connection->prepare("SELECT * FROM carreras WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function update(Carrera $carrera): void {
        $sql = "UPDATE carreras SET 
                    cliente=:cliente, taxi=:taxi, kilometros=:kilometros,
                    barrioInicio=:barrioInicio, barrioLlegada=:barrioLlegada,
                    cantidadPasajeros=:cantidadPasajeros, taxista=:taxista,
                    precio=:precio, duracionMinutos=:duracionMinutos
                WHERE id=:id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id'                => $carrera->id,
            'cliente'           => $carrera->cliente,
            'taxi'              => $carrera->taxi,
            'kilometros'        => $carrera->kilometros,
            'barrioInicio'      => $carrera->barrioInicio,
            'barrioLlegada'     => $carrera->barrioLlegada,
            'cantidadPasajeros' => $carrera->cantidadPasajeros,
            'taxista'           => $carrera->taxista,
            'precio'            => $carrera->precio,
            'duracionMinutos'   => $carrera->duracionMinutos,
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->connection->prepare("DELETE FROM carreras WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    private function hydrate(array $row): Carrera {
        return new Carrera(
            (int)   $row['id'],
                    $row['cliente'],
                    $row['taxi'],
            (float) $row['kilometros'],
                    $row['barrioInicio'],
                    $row['barrioLlegada'],
            (int)   $row['cantidadPasajeros'],
                    $row['taxista'],
            (float) $row['precio'],
            (int)   $row['duracionMinutos']
        );
    }
}
