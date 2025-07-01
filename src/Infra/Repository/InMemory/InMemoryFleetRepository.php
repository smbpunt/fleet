<?php

declare(strict_types=1);

namespace App\Infra\Repository\InMemory;

use App\Domain\Exception\Fleet\FleetNotFoundException;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;

class InMemoryFleetRepository implements FleetRepositoryInterface
{
    /**
     * @var array<string, Fleet>
     */
    private array $fleets = [];

    public function save(Fleet $fleet, bool $flush = false): void
    {
        $this->fleets[$fleet->getUserId()] = $fleet;
    }

    public function findByUserId(string $userId): Fleet
    {
        return $this->fleets[$userId] ?? throw new FleetNotFoundException($userId);
    }
}
