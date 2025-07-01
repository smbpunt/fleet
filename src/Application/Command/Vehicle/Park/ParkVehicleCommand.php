<?php

declare(strict_types=1);

namespace App\Application\Command\Vehicle\Park;

use App\Application\Command\CommandInterface;

final readonly class ParkVehicleCommand implements CommandInterface
{
    public function __construct(
        public string $plateNumber,
        public float  $latitude,
        public float  $longitude,
        public ?float $altitude = null,
    ) {}
}
