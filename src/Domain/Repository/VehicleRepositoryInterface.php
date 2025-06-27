<?php

declare(strict_types=1);

namespace Punt\Fleet\Domain\Repository;

use Punt\Fleet\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function save(Vehicle $vehicle): void;

    public function findByPlate(string $plateNumber): ?Vehicle;
}
