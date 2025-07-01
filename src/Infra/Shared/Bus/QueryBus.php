<?php

declare(strict_types=1);

namespace App\Infra\Shared\Bus;

use LogicException;
use App\Application\Query\QueryHandlerInterface;
use App\Application\Query\QueryInterface;
use App\Application\Shared\Bus\QueryBusInterface;
use App\Infra\Container\ContainerInterface;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(private ContainerInterface $container) {}

    public function dispatch(QueryInterface $query): mixed
    {
        $handler = $this->container->get($query::class);
        if (!$handler instanceof QueryHandlerInterface) {
            throw new LogicException();
        }

        return $handler($query);
    }
}
