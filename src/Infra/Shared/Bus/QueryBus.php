<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Shared\Bus;

use LogicException;
use Punt\Fleet\App\Query\QueryHandlerInterface;
use Punt\Fleet\App\Query\QueryInterface;
use Punt\Fleet\App\Shared\Bus\QueryBusInterface;
use Punt\Fleet\Infra\Container\ContainerInterface;

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
