<?php

declare(strict_types=1);

namespace App\Tests\Behat\Vehicle;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use App\Application\Command\Fleet\Register\RegisterFleetCommand;
use App\Application\Command\Vehicle\Register\RegisterVehicleCommand;
use App\Application\Shared\Bus\CommandBusInterface;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Tests\Behat\ContainerAwareTrait;

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
