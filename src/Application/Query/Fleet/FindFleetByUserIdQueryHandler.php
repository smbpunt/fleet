<?php

declare(strict_types=1);

namespace App\Application\Query\Fleet;

use App\Application\Query\QueryHandlerInterface;
use App\Application\Query\QueryInterface;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Infra\Container\ContainerInterface;

readonly class FindFleetByUserIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param FindFleetByUserIdQuery $query
     * @return Fleet
     */
    public function __invoke(QueryInterface $query): Fleet
    {
        /** @var FleetRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(FleetRepositoryInterface::class);

        return $fleetRepository->findByUserId($query->userId);
    }
}
