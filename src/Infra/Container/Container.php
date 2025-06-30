<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Container;

use Punt\Fleet\App\Shared\Bus\CommandBusInterface;
use Punt\Fleet\App\Shared\Bus\QueryBusInterface;
use Punt\Fleet\Domain\Repository\FleetRepositoryInterface;
use Punt\Fleet\Domain\Repository\VehicleRepositoryInterface;
use Punt\Fleet\Infra\Repository\FleetRepository;
use Punt\Fleet\Infra\Repository\VehicleRepository;
use Punt\Fleet\Infra\Shared\Bus\CommandBus;
use Punt\Fleet\Infra\Shared\Bus\QueryBus;

class Container implements ContainerInterface
{
    public function __construct(
        /** @var array<string, object> */
        private array $services = [],
    ) {}

    public function set(string $id, object $service): static
    {
        $this->services[$id] = $service;

        return $this;
    }

    public function get(string $id): ?object
    {
        return $this->services[$id] ?? null;
    }

    public static function boot(): self
    {
        $container = new self([
            FleetRepositoryInterface::class => new FleetRepository(),
            VehicleRepositoryInterface::class => new VehicleRepository(),
        ]);

        // Commands
        $container->set(CommandBusInterface::class, new CommandBus($container));
        //        $container->set(RegisterFleetCommand::class, new RegisterFleetCommandHandler($container));
        //        $container->set(RegisterVehicleCommand::class, new RegisterVehicleCommandHandler($container));

        // Queries
        $container->set(QueryBusInterface::class, new QueryBus($container));
        //        $container->set(FindFleetByUserIdQuery::class, new FindFleetByUserIdQueryHandler($container));

        return $container;
    }
}
