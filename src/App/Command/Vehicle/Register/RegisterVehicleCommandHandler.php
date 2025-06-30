<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command\Vehicle\Register;

use Punt\Fleet\App\Command\CommandInterface;
use Punt\Fleet\App\Command\CommandHandlerInterface;
use Punt\Fleet\Domain\Model\Fleet;
use Punt\Fleet\Domain\Model\Vehicle;
use Punt\Fleet\Domain\Repository\FleetRepositoryInterface;
use Punt\Fleet\Domain\Repository\VehicleRepositoryInterface;
use Punt\Fleet\Infra\Container\ContainerInterface;
use RuntimeException;

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
        $vehicle = $vehicleRepository->findByPlateNumber($command->plateNumber);
        if (null === $vehicle) {
            $vehicle = Vehicle::create($command->plateNumber);
            $vehicleRepository->save($vehicle);
        }

        /** @var FleetRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(FleetRepositoryInterface::class);
        $fleet = $fleetRepository->findByUserId($command->userId);
        if (null === $fleet) {
            // @todo exception domain ?
            throw new RuntimeException('Fleet not found for user ID: ' . $command->userId);
        }

        $fleet->registerVehicle($vehicle);
        $fleetRepository->save($fleet);
        return $fleet;
    }
}
