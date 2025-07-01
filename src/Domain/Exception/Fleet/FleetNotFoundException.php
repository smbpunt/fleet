<?php

declare(strict_types=1);

namespace App\Domain\Exception\Fleet;

use App\Domain\Exception\DomainException;

class FleetNotFoundException extends DomainException
{
    public function __construct(
        private readonly string $userId,
    ) {
        parent::__construct(sprintf('Fleet not found for user ID: %s', $this->userId));
    }
}
