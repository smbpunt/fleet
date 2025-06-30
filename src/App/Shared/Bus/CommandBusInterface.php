<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Shared\Bus;

use Punt\Fleet\App\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
