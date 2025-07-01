<?php

declare(strict_types=1);

namespace App\Infra\Repository\Doctrine;

use App\Domain\Exception\Vehicle\VehicleNotFoundException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
#[AsAlias(VehicleRepositoryInterface::class, true)]
class DoctrineVehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function save(Vehicle $vehicle, bool $flush = false): void
    {
        $this->getEntityManager()->persist($vehicle);
        if ($flush) {
            $this->getEntityManager()->flush();
            dump($vehicle);
        }
    }

    public function findByPlateNumber(string $plateNumber): Vehicle
    {
        $vehicle = $this->findOneBy(['plateNumber' => $plateNumber]);

        return $vehicle ?? throw new VehicleNotFoundException($plateNumber);
    }
}
