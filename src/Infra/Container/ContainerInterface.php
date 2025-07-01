<?php

declare(strict_types=1);

namespace App\Infra\Container;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    public function set(string $id, object $service): static;

    public function get(string $id): ?object;
}
