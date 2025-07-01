<?php

declare(strict_types=1);

namespace App\Application\Command\Vehicle\Register;

use App\Application\Command\CommandInterface;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Exception\Vehicle\VehicleNotFoundException;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Infra\Container\ContainerInterface;

readonly class RegisterVehicleCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param RegisterVehicleCommand $command
     * @return Fleet
     */
    public function __invoke(CommandInterface $command): Fleet
    {
        /** @var VehicleRepositoryInterface $vehicleRepository */
        $vehicleRepository = $this->container->get(VehicleRepositoryInterface::class);
        try {
            $vehicle = $vehicleRepository->findByPlateNumber($command->plateNumber);
        } catch (VehicleNotFoundException) {
            $vehicle = Vehicle::create($command->plateNumber);
            $vehicleRepository->save($vehicle);
        }

        /** @var FleetRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(FleetRepositoryInterface::class);
        $fleet = $fleetRepository->findByUserId($command->userId);

        $fleet->registerVehicle($vehicle);
        $fleetRepository->save($fleet);
        return $fleet;
    }
}
