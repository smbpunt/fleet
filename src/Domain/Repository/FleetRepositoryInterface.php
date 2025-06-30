<?php

declare(strict_types=1);

namespace Punt\Fleet\Domain\Repository;

use Punt\Fleet\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function save(Fleet $fleet): void;

    public function findByUserId(string $userId): Fleet;
}
