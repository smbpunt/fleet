<?php

declare(strict_types=1);

namespace App\Application\Query\Fleet;

use App\Application\Query\QueryInterface;

final readonly class FindFleetByUserIdQuery implements QueryInterface
{
    public function __construct(
        public string $userId,
    ) {}
}
