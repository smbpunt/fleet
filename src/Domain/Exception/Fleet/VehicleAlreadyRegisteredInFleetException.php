<?php

declare(strict_types=1);

namespace App\Domain\Exception\Fleet;

use App\Domain\Exception\DomainException;

class VehicleAlreadyRegisteredInFleetException extends DomainException
{
    public function __construct(
        private readonly string $vehiclePlate,
    ) {
        parent::__construct(sprintf('The vehicle (plate=%s) is already registered in fleet.', $this->vehiclePlate));
    }
}
