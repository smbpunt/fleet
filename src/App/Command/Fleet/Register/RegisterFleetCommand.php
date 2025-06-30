<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command\Fleet\Register;

use Punt\Fleet\App\Command\CommandInterface;

class RegisterFleetCommand implements CommandInterface
{
    public function __construct(
        public string $userId,
    ) {}
}
