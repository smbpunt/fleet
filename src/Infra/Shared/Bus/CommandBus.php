<?php

declare(strict_types=1);

namespace App\Infra\Shared\Bus;

use LogicException;
use App\Application\Command\CommandInterface;
use App\Application\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\CommandBusInterface;
use App\Infra\Container\ContainerInterface;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(private ContainerInterface $container) {}

    public function dispatch(CommandInterface $command): mixed
    {
        $handler = $this->container->get($command::class);
        if (!$handler instanceof CommandHandlerInterface) {
            throw new LogicException();
        }

        return $handler($command);
    }
}
