<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Container;

interface ContainerInterface
{
    public function set(string $id, object $service): static;

    public function get(string $id): ?object;
}
