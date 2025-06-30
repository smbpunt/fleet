<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Query\Vehicle;

use Punt\Fleet\App\Query\QueryInterface;

final readonly class FindVehicleByPlateQuery implements QueryInterface
{
    public function __construct(
        public string $plateNumber,
    ) {}
}
