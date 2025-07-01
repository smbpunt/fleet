<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\Fleet\VehicleAlreadyRegisteredInFleetException;

final class Fleet
{
    /**
     * @var Vehicle[]|iterable
     */
    private iterable $vehicles;

    private function __construct(
        private readonly string $userId,
    )
    {
        $this->vehicles = [];
    }

    public static function create(string $userId): self
    {
        return new self($userId);
    }

    public function registerVehicle(Vehicle $vehicle): self
    {
        foreach ($this->vehicles as $existingVehicle) {
            if ($existingVehicle->getPlateNumber() === $vehicle->getPlateNumber()) {
                throw new VehicleAlreadyRegisteredInFleetException($vehicle->getPlateNumber());
            }
        }

        $this->vehicles[] = $vehicle;

        return $this;
    }

    public function hasVehicleRegistered(Vehicle $vehicle): bool
    {
        foreach ($this->vehicles as $existingVehicle) {
            if ($existingVehicle->getPlateNumber() === $vehicle->getPlateNumber()) {
                return true;
            }
        }

        return false;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
