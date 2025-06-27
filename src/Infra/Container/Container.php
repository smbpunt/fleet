<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Container;

use Punt\Fleet\Domain\Repository\FleetRepositoryInterface;
use Punt\Fleet\Domain\Repository\VehicleRepositoryInterface;
use Punt\Fleet\Infra\Repository\FleetRepository;
use Punt\Fleet\Infra\Repository\VehicleRepository;

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
        return new self([
            FleetRepositoryInterface::class => new FleetRepository(),
            VehicleRepositoryInterface::class => new VehicleRepository(),
        ]);
    }
}
