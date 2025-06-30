<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command;

interface CommandHandlerInterface
{
    public function __invoke(CommandInterface $command): mixed;
}
