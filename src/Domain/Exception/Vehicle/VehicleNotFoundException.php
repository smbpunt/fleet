<?php

declare(strict_types=1);

namespace Punt\Fleet\Domain\Exception\Vehicle;

use Punt\Fleet\Domain\Exception\DomainException;

class VehicleNotFoundException extends DomainException
{
    public function __construct(
        private readonly string $plateNumber,
    ) {
        parent::__construct(sprintf('Vehicle not found with plate number: %s', $this->plateNumber));
    }
}
