<?php

declare(strict_types=1);

namespace App\Infra\Repository;

use App\Domain\Exception\Vehicle\VehicleNotFoundException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;

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

    public function findByPlateNumber(string $plateNumber): Vehicle
    {
        return $this->vehicles[$plateNumber] ?? throw new VehicleNotFoundException($plateNumber);
    }
}
