<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command\Vehicle\Register;

use Punt\Fleet\App\Command\CommandInterface;

final readonly class RegisterVehicleCommand implements CommandInterface
{
    public function __construct(
        public string $userId,
        public string $plateNumber,
    ) {}
}
