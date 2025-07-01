<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final readonly class Location
{
    private ?float $latitude;
    private ?float $longitude;
    private ?float $altitude;

    public function __construct(
        ?float $latitude,
        ?float $longitude,
        ?float $altitude = null,
    ) {
        $this->validateCoordinates($latitude, $longitude);
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    private function validateCoordinates(?float $latitude, ?float $longitude): void
    {
        if (null === $latitude || null === $longitude) {
            return;
        }

        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException('Invalid latitude value');
        }
        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException('Invalid longitude value');
        }
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function equals(Location $other): bool
    {
        return $this->latitude === $other->latitude
            && $this->longitude === $other->longitude
            && $this->altitude === $other->altitude;
    }

    public function __toString(): string
    {
        return sprintf(
            'Location(latitude: %f, longitude: %f, altitude: %s)',
            $this->latitude,
            $this->longitude,
            null !== $this->altitude ? (string) $this->altitude : 'null'
        );
    }
}
