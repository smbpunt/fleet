<?php

declare(strict_types=1);

namespace App\Infra\Repository\Doctrine;

use App\Domain\Exception\Fleet\FleetNotFoundException;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends ServiceEntityRepository<Fleet>
 */
#[AsAlias(FleetRepositoryInterface::class, true)]
class DoctrineFleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    public function save(Fleet $fleet, bool $flush = false): void
    {
        $this->getEntityManager()->persist($fleet);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUserId(string $userId): Fleet
    {
        $fleet = $this->find($userId);

        return $fleet ?? throw new FleetNotFoundException($userId);
    }
}
