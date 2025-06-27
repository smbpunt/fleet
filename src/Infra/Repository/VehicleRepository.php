<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Repository;

use Punt\Fleet\Domain\Model\Vehicle;
use Punt\Fleet\Domain\Repository\VehicleRepositoryInterface;

class VehicleRepository implements VehicleRepositoryInterface
{
    /**
     * @var array<string, Vehicle>
     */
    private array $vehicles = [];

    public function save(Vehicle $vehicle): void
    {
        $this->vehicles[$vehicle->getPlateNumber()] = $vehicle;
    }

    public function findByPlate(string $plateNumber): ?Vehicle
    {
        return $this->vehicles[$plateNumber] ?? null;
    }
}
