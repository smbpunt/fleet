<?php

declare(strict_types=1);

namespace Punt\Fleet\Tests\Behat\Vehicle\Register;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;

class RegisterVehicleContext implements Context
{
    #[Given('my fleet')]
    public function myFleet(): void
    {
        throw new PendingException();
    }

    #[Given('a vehicle')]
    public function aVehicle(): void
    {
        throw new PendingException();
    }

    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        throw new PendingException();
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        throw new PendingException();
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        throw new PendingException();
    }

    #[When('I try to register this vehicle into my fleet')]
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        throw new PendingException();
    }

    #[Then('I should be informed this this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        throw new PendingException();
    }

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): void
    {
        throw new PendingException();
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        throw new PendingException();
    }
}
