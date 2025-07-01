<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function save(Fleet $fleet, bool $flush = false): void;

    public function findByUserId(string $userId): Fleet;
}
