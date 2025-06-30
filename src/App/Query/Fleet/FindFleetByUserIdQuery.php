<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Query\Fleet;

use Punt\Fleet\App\Query\QueryInterface;

final readonly class FindFleetByUserIdQuery implements QueryInterface
{
    public function __construct(
        public string $userId,
    ) {}
}
