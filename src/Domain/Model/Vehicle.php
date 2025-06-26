<?php

declare(strict_types=1);

namespace Punt\Fleet\Domain\Model;

use Punt\Fleet\Domain\Exception\Vehicle\AlreadyParkedAtThisLocationException;
use Punt\Fleet\Domain\ValueObject\Location;

final class Vehicle
{
    public ?Location $location = null;

    private function __construct(
        private readonly string $plateNumber,
    ) {}

    public static function create(string $plateNumber): self
    {
        return new self($plateNumber);
    }

    public function park(Location $location): self
    {
        if (null !== $this->location && $this->location->equals($location)) {
            throw new AlreadyParkedAtThisLocationException($this->plateNumber);
        }

        $this->location = $location;
        return $this;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}
