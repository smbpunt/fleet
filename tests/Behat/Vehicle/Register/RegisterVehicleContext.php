<?php

declare(strict_types=1);

namespace App\Tests\Behat\Vehicle\Register;

use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use App\Application\Command\Fleet\Register\RegisterFleetCommand;
use App\Application\Command\Vehicle\Register\RegisterVehicleCommand;
use App\Application\Query\Fleet\FindFleetByUserIdQuery;
use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\Shared\Bus\QueryBusInterface;
use App\Domain\Exception\Fleet\VehicleAlreadyRegisteredInFleetException;
use App\Domain\Model\Fleet;
use App\Tests\Behat\Vehicle\SharedVehicleContext;
use RuntimeException;

class RegisterVehicleContext extends SharedVehicleContext
{
    private ?Fleet $anotherFleet = null;
    private ?VehicleAlreadyRegisteredInFleetException $vehicleAlreadyRegisteredInFleetException = null;

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): void
    {
        $registerFleet = new RegisterFleetCommand('another-user');
        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $this->anotherFleet = $bus->dispatch($registerFleet);
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
}
