<?php

declare(strict_types=1);

namespace App\Application\Query\Vehicle;

use App\Application\Query\QueryHandlerInterface;
use App\Application\Query\QueryInterface;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Infra\Container\ContainerInterface;

class FindVehicleByPlateQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param FindVehicleByPlateQuery $query
     * @return Vehicle
     */
    public function __invoke(QueryInterface $query): Vehicle
    {
        /** @var VehicleRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(VehicleRepositoryInterface::class);

        return $fleetRepository->findByPlateNumber($query->plateNumber);
    }
}
