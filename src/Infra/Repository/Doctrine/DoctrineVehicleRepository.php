<?php

namespace App\Infra\Repository\Doctrine;

use App\Domain\Exception\Vehicle\VehicleNotFoundException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(VehicleRepositoryInterface::class, true)]
class DoctrineVehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function save(Vehicle $vehicle, bool $flush = true): void
    {
        $this->getEntityManager()->persist($vehicle);
        if ($flush) {
            echo 'Saving vehicle with plate number: ' . $vehicle->getPlateNumber() . PHP_EOL;

            $this->getEntityManager()->flush();
        }
    }

    public function findByPlateNumber(string $plateNumber): Vehicle
    {
        $vehicle = $this->findOneBy(['plateNumber' => $plateNumber]);

        return $vehicle ?? throw new VehicleNotFoundException($plateNumber);
    }
}
