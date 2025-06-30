<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Query\Vehicle;

use Punt\Fleet\App\Query\QueryHandlerInterface;
use Punt\Fleet\App\Query\QueryInterface;
use Punt\Fleet\Domain\Model\Vehicle;
use Punt\Fleet\Domain\Repository\VehicleRepositoryInterface;
use Punt\Fleet\Infra\Container\ContainerInterface;

class FindVehicleByPlateQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param FindVehicleByPlateQuery $query
     * @return Vehicle|null
     */
    public function __invoke(QueryInterface $query): ?Vehicle
    {
        /** @var VehicleRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(VehicleRepositoryInterface::class);

        return $fleetRepository->findByPlateNumber($query->plateNumber);
    }
}
