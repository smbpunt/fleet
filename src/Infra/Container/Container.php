<?php

declare(strict_types=1);

namespace App\Infra\Container;

use App\Application\Command\Fleet\Register\RegisterFleetCommand;
use App\Application\Command\Fleet\Register\RegisterFleetCommandHandler;
use App\Application\Command\Vehicle\Park\ParkVehicleCommand;
use App\Application\Command\Vehicle\Park\ParkVehicleCommandHandler;
use App\Application\Command\Vehicle\Register\RegisterVehicleCommand;
use App\Application\Command\Vehicle\Register\RegisterVehicleCommandHandler;
use App\Application\Query\Fleet\FindFleetByUserIdQuery;
use App\Application\Query\Fleet\FindFleetByUserIdQueryHandler;
use App\Application\Query\Vehicle\FindVehicleByPlateQuery;
use App\Application\Query\Vehicle\FindVehicleByPlateQueryHandler;
use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\Shared\Bus\QueryBusInterface;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Infra\Repository\FleetRepository;
use App\Infra\Repository\VehicleRepository;
use App\Infra\Shared\Bus\CommandBus;
use App\Infra\Shared\Bus\QueryBus;

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
        $container->set(RegisterFleetCommand::class, new RegisterFleetCommandHandler($container));
        $container->set(RegisterVehicleCommand::class, new RegisterVehicleCommandHandler($container));
        $container->set(ParkVehicleCommand::class, new ParkVehicleCommandHandler($container));

        // Queries
        $container->set(QueryBusInterface::class, new QueryBus($container));
        $container->set(FindFleetByUserIdQuery::class, new FindFleetByUserIdQueryHandler($container));
        $container->set(FindVehicleByPlateQuery::class, new FindVehicleByPlateQueryHandler($container));

        return $container;
    }
}
