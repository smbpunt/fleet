<?php

declare(strict_types=1);

namespace Punt\Fleet\Tests\Behat\Vehicle;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Punt\Fleet\App\Command\Fleet\Register\RegisterFleetCommand;
use Punt\Fleet\App\Command\Vehicle\Register\RegisterVehicleCommand;
use Punt\Fleet\App\Shared\Bus\CommandBusInterface;
use Punt\Fleet\Domain\Model\Fleet;
use Punt\Fleet\Domain\Model\Vehicle;
use Punt\Fleet\Tests\Behat\ContainerAwareTrait;

abstract class SharedVehicleContext implements Context
{
    use ContainerAwareTrait;

    protected ?Vehicle $vehicle = null;
    protected ?Fleet $fleet = null;

    #[Given('my fleet')]
    public function myFleet(): void
    {
        $registerFleet = new RegisterFleetCommand('app-user');
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $this->fleet = $bus->dispatch($registerFleet);
    }

    #[Given('a vehicle')]
    public function aVehicle(): void
    {
        $this->vehicle = Vehicle::create('ABC-123');
    }

    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->registerVehicleInFleet($this->fleet, $this->vehicle);
    }

    protected function registerVehicleInFleet(Fleet $fleet, Vehicle $vehicle): void
    {
        $registerVehicle = new RegisterVehicleCommand($fleet->getUserId(), $vehicle->getPlateNumber());
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $bus->dispatch($registerVehicle);
    }
}
