<?php

declare(strict_types=1);

namespace Punt\Fleet\Domain\Exception\Vehicle;

use Punt\Fleet\Domain\Exception\DomainException;

class AlreadyParkedAtThisLocationException extends DomainException
{
    public function __construct(
        private readonly string $vehiclePlate,
    ) {
        parent::__construct(sprintf('The vehicle (plate=%s) is already parked at this location.', $this->vehiclePlate));
    }
}
