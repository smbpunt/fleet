<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command\Vehicle\Park;

use Punt\Fleet\App\Command\CommandInterface;

final readonly class ParkVehicleCommand implements CommandInterface
{
    public function __construct(
        public string $plateNumber,
        public float  $latitude,
        public float  $longitude,
        public ?float $altitude = null,
    ) {}
}
