<?php

declare(strict_types=1);

namespace App\Application\Command\Vehicle\Park;

use App\Application\Command\CommandInterface;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Domain\ValueObject\Location;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: ParkVehicleCommand::class)]
readonly class ParkVehicleCommandHandler implements CommandHandlerInterface
{
    public function __construct(private PsrContainerInterface $container) {}

    /**
     * @param ParkVehicleCommand $command
     * @return Vehicle
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
        $vehicle->park($location);

        $vehicleRepository->save($vehicle, true);

        return $vehicle;
    }
}
