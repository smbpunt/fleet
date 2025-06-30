<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command\Vehicle\Park;

use Punt\Fleet\App\Command\CommandInterface;
use Punt\Fleet\App\Command\CommandHandlerInterface;
use Punt\Fleet\Domain\Model\Vehicle;
use Punt\Fleet\Domain\Repository\VehicleRepositoryInterface;
use Punt\Fleet\Domain\ValueObject\Location;
use Punt\Fleet\Infra\Container\ContainerInterface;
use RuntimeException;

class ParkVehicleCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param ParkVehicleCommand $command
     */
    public function __invoke(CommandInterface $command): Vehicle
    {
        $location = new Location(
            $command->latitude,
            $command->longitude,
            $command->altitude
        );

        /** @var VehicleRepositoryInterface $vehicleRepository */
        $vehicleRepository = $this->container->get(VehicleRepositoryInterface::class);
        $vehicle = $vehicleRepository->findByPlateNumber($command->plateNumber);
        if (null === $vehicle) {
            // @todo exception domain/logic ?
            throw new RuntimeException('Vehicle not found with plate number: ' . $command->plateNumber);
        }

        $vehicle->park($location);
        $vehicleRepository->save($vehicle);

        return $vehicle;
    }
}
