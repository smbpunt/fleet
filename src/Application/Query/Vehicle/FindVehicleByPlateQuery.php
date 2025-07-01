<?php

declare(strict_types=1);

namespace App\Application\Query\Vehicle;

use App\Application\Query\QueryInterface;

final readonly class FindVehicleByPlateQuery implements QueryInterface
{
    public function __construct(
        public string $plateNumber,
    ) {}
}
