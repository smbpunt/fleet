<?php

declare(strict_types=1);

namespace App\Application\Shared\Bus;

use App\Application\Query\QueryInterface;

interface QueryBusInterface
{
    public function dispatch(QueryInterface $query): mixed;
}
