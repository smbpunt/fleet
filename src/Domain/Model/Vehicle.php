<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\Vehicle\AlreadyParkedAtThisLocationException;
use App\Domain\ValueObject\Location;

final class Vehicle
{
    private ?Location $location = null;

    private function __construct(
        private readonly string $plateNumber,
    ) {}

    public static function create(string $plateNumber): self
    {
        return new self($plateNumber);
    }

    public function park(Location $location): self
    {
        if (null !== $this->location && $location->equals($this->location)) {
            throw new AlreadyParkedAtThisLocationException($this->plateNumber);
        }

        $this->location = $location;

        return $this;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }
}
