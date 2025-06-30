<?php

declare(strict_types=1);

namespace Punt\Fleet\Tests\Behat\Vehicle\Park;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use Punt\Fleet\Tests\Behat\Vehicle\SharedVehicleContext;

class ParkVehicleContext extends SharedVehicleContext
{
    #[Given('a location')]
    public function aLocation(): void
    {
        throw new PendingException();
    }

    #[When('I park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        throw new PendingException();
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
