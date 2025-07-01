<?php

declare(strict_types=1);

namespace App\Application\Command\Vehicle\Register;

use App\Application\Command\CommandInterface;

final readonly class RegisterVehicleCommand implements CommandInterface
{
    public function __construct(
        public string $userId,
        public string $plateNumber,
    ) {}
}
