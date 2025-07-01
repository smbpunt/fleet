<?php

declare(strict_types=1);

namespace App\Tests\Behat\Vehicle\Park;

use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;
use App\Application\Command\Vehicle\Park\ParkVehicleCommand;
use App\Application\Query\Vehicle\FindVehicleByPlateQuery;
use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\Shared\Bus\QueryBusInterface;
use App\Domain\Exception\Vehicle\AlreadyParkedAtThisLocationException;
use App\Domain\Model\Vehicle;
use App\Domain\ValueObject\Location;
use App\Tests\Behat\Vehicle\SharedVehicleContext;
use RuntimeException;

class ParkVehicleContext extends SharedVehicleContext
{
    protected ?Location $location = null;
    private ?AlreadyParkedAtThisLocationException $alreadyParkedAtThisLocationException = null;

    #[Given('a location')]
    public function aLocation(): void
    {
        $this->location = new Location(48.8566, 2.3522, 35.0);
    }

    #[When('I park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->parkVehicle($this->vehicle, $this->location);
    }

    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        $query = new FindVehicleByPlateQuery($this->vehicle->getPlateNumber());
        /** @var QueryBusInterface $bus */
        $bus = $this->container->get(QueryBusInterface::class);
        /** @var ?Vehicle $vehicle */
        $vehicle = $bus->dispatch($query);

        if (null === $vehicle) {
            throw new RuntimeException('Vehicle not found');
        }

        if (!$this->location->equals($vehicle->location)) {
            throw new RuntimeException(
                sprintf(
                    'Expected vehicle location to be %s, but got %s',
                    $this->location,
                    $vehicle->location
                )
            );
        }
    }

    #[Given('my vehicle has been parked into this location')]
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->parkVehicle($this->vehicle, $this->location);
    }

    #[When('I try to park my vehicle at this location')]
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->parkVehicle($this->vehicle, $this->location);
        } catch (AlreadyParkedAtThisLocationException $e) {
            $this->alreadyParkedAtThisLocationException = $e;
        }
    }

    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        $this->alreadyParkedAtThisLocationException ?? throw new RuntimeException(
            'I should be informed that my vehicle is already parked at this location'
        );
    }

    public function parkVehicle(Vehicle $vehicle, Location $location): void
    {
        $parkVehicle = new ParkVehicleCommand(
            plateNumber: $vehicle->getPlateNumber(),
            latitude: $location->getLatitude(),
            longitude: $location->getLongitude(),
            altitude: $location->getAltitude(),
        );

        /** @var CommandBusInterface $bus */
        $bus = $this->container->get(CommandBusInterface::class);
        $bus->dispatch($parkVehicle);
    }
}
