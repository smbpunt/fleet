<?php

declare(strict_types=1);

namespace Punt\Fleet\Tests\Behat\Vehicle\Register;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use Punt\Fleet\App\Command\Fleet\Register\RegisterFleetCommand;
use Punt\Fleet\App\Command\Vehicle\Register\RegisterVehicleCommand;
use Punt\Fleet\App\Query\Fleet\FindFleetByUserIdQuery;
use Punt\Fleet\App\Shared\Bus\CommandBusInterface;
use Punt\Fleet\App\Shared\Bus\QueryBusInterface;
use Punt\Fleet\Domain\Exception\Fleet\VehicleAlreadyRegisteredInFleetException;
use Punt\Fleet\Domain\Model\Fleet;
use Punt\Fleet\Domain\Model\Vehicle;
use Punt\Fleet\Tests\Behat\ContainerAwareTrait;
use RuntimeException;

class RegisterVehicleContext implements Context
{
    use ContainerAwareTrait;

    private ?Vehicle $vehicle = null;
    private ?Fleet $fleet = null;
    private ?Fleet $anotherFleet = null;
    private ?VehicleAlreadyRegisteredInFleetException $vehicleAlreadyRegisteredInFleetException = null;

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

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): void
    {
        $registerFleet = new RegisterFleetCommand('another-user');
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $this->anotherFleet = $bus->dispatch($registerFleet);
    }

    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $registerVehicle = new RegisterVehicleCommand($this->fleet->getUserId(), $this->vehicle->getPlateNumber());
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $bus->dispatch($registerVehicle);
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        $this->registerVehicleInFleet($this->anotherFleet, $this->vehicle);
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $this->registerVehicleInFleet($this->fleet, $this->vehicle);
    }

    #[When('I try to register this vehicle into my fleet')]
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        $registerVehicle = new RegisterVehicleCommand($this->fleet->getUserId(), $this->vehicle->getPlateNumber());
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        try {
            $bus->dispatch($registerVehicle);
        } catch (VehicleAlreadyRegisteredInFleetException $e) {
            $this->vehicleAlreadyRegisteredInFleetException = $e;
        }
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $query = new FindFleetByUserIdQuery($this->fleet->getUserId());
        /** @var QueryBusInterface $bus */
        $bus = $this->container->get(QueryBusInterface::class);
        /** @var ?Fleet $fleet */
        $fleet = $bus->dispatch($query);

        if (!$fleet->hasVehicleRegistered($this->vehicle)) {
            throw new RuntimeException('The vehicle is not part of the fleet.');
        }
    }

    #[Then('I should be informed this this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        $this->vehicleAlreadyRegisteredInFleetException ?? throw new RuntimeException(
            'I should be informed this this vehicle has already been registered into my fleet'
        );
    }

    private function registerVehicleInFleet(Fleet $fleet, Vehicle $vehicle): void
    {
        $registerVehicle = new RegisterVehicleCommand($fleet->getUserId(), $vehicle->getPlateNumber());
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $bus->dispatch($registerVehicle);
    }
}
