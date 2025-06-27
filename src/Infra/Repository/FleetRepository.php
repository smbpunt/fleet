<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Repository;

use Punt\Fleet\Domain\Model\Fleet;
use Punt\Fleet\Domain\Repository\FleetRepositoryInterface;

class FleetRepository implements FleetRepositoryInterface
{
    /**
     * @var array<string, Fleet>
     */
    private array $fleets = [];

    public function save(Fleet $fleet): void
    {
        $this->fleets[$fleet->getUserId()] = $fleet;
    }

    public function findByUserId(string $userId): ?Fleet
    {
        return $this->fleets[$userId] ?? null;
    }
}
