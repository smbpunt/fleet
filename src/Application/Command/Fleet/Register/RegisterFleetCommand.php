<?php

declare(strict_types=1);

namespace App\Application\Command\Fleet\Register;

use App\Application\Command\CommandInterface;

final readonly class RegisterFleetCommand implements CommandInterface
{
    public function __construct(
        public string $userId,
    ) {}
}
