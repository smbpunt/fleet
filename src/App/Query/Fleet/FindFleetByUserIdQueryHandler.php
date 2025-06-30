<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Query\Fleet;

use Punt\Fleet\App\Query\QueryHandlerInterface;
use Punt\Fleet\App\Query\QueryInterface;
use Punt\Fleet\Domain\Model\Fleet;
use Punt\Fleet\Domain\Repository\FleetRepositoryInterface;
use Punt\Fleet\Infra\Container\ContainerInterface;

readonly class FindFleetByUserIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param FindFleetByUserIdQuery $query
     * @return Fleet|null
     */
    public function __invoke(QueryInterface $query): ?Fleet
    {
        /** @var FleetRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(FleetRepositoryInterface::class);

        return $fleetRepository->findByUserId($query->userId);
    }
}
