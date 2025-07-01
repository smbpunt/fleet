<?php

declare(strict_types=1);

namespace App\Infra\Repository\InMemory;

use App\Domain\Exception\Vehicle\VehicleNotFoundException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;

class InMemoryVehicleRepository implements VehicleRepositoryInterface
{
    /**
     * @var array<string, Vehicle>
     */
    private array $vehicles = [];

    public function save(Vehicle $vehicle, bool $flush = false): void
    {
        $this->vehicles[$vehicle->getPlateNumber()] = $vehicle;
    }

    public function findByPlateNumber(string $plateNumber): Vehicle
    {
        return $this->vehicles[$plateNumber] ?? throw new VehicleNotFoundException($plateNumber);
    }
}
