<?php

declare(strict_types=1);

namespace Punt\Fleet\Tests\Behat;

use Punt\Fleet\Infra\Container\Container;
use Punt\Fleet\Infra\Container\ContainerInterface;

trait BootContainerTrait
{
    private ContainerInterface $container;

    public function __construct()
    {
        $this->container = Container::boot();
    }
}
