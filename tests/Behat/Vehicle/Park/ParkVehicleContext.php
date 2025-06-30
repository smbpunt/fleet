<?php

declare(strict_types=1);

namespace Punt\Fleet\Tests\Behat\Vehicle\Park;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use Punt\Fleet\App\Command\Vehicle\Park\ParkVehicleCommand;
use Punt\Fleet\App\Shared\Bus\CommandBusInterface;
use Punt\Fleet\Domain\ValueObject\Location;
use Punt\Fleet\Tests\Behat\Vehicle\SharedVehicleContext;

class ParkVehicleContext extends SharedVehicleContext
{
    protected ?Location $location = null;

    #[Given('a location')]
    public function aLocation(): void
    {
        $this->location = new Location(48.8566, 2.3522, 35.0);
    }

    #[When('I park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        $parkVehicle = new ParkVehicleCommand(
            plateNumber: $this->vehicle->getPlateNumber(),
            latitude: $this->location->getLatitude(),
            longitude: $this->location->getLongitude(),
            altitude: $this->location->getAltitude(),
        );

        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $bus->dispatch($parkVehicle);
    }

    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        throw new PendingException();
    }

    #[Given('my vehicle has been parked into this location')]
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        throw new PendingException();
    }

    #[When('I try to park my vehicle at this location')]
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        throw new PendingException();
    }

    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        throw new PendingException();
    }
}
