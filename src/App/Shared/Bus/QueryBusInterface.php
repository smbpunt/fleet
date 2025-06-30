<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Shared\Bus;

use Punt\Fleet\App\Query\QueryInterface;

interface QueryBusInterface
{
    public function dispatch(QueryInterface $query): mixed;
}
