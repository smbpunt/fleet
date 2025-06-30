<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Query;

interface QueryHandlerInterface
{
    public function __invoke(QueryInterface $query): mixed;
}
