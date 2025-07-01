<?php

namespace App\Infra\Repository\Doctrine;

use App\Domain\Exception\Fleet\FleetNotFoundException;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(FleetRepositoryInterface::class, true)]
class DoctrineFleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }


    public function save(Fleet $fleet, bool $flush = true): void
    {
        $this->getEntityManager()->persist($fleet);
        if ($flush) {
            echo 'Saving fleet for user: ' . $fleet->getUserId() . PHP_EOL;

            $this->getEntityManager()->flush();
        }
    }

    public function findByUserId(string $userId): Fleet
    {
        $fleet = $this->find($userId);

        return $fleet ?? throw new FleetNotFoundException($userId);
    }
}
