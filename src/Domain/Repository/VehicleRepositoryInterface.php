<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function save(Vehicle $vehicle, bool $flush = false): void;

    public function findByPlateNumber(string $plateNumber): Vehicle;
}
