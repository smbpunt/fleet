<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Infra\Container\Container;
use App\Infra\Container\ContainerInterface;

trait ContainerAwareTrait
{
    protected ContainerInterface $container;

    public function __construct()
    {
        $this->container = Container::boot();
    }
}
