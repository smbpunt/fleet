<?php

declare(strict_types=1);

namespace Punt\Fleet\Infra\Shared\Bus;

use LogicException;
use Punt\Fleet\App\Command\CommandInterface;
use Punt\Fleet\App\Command\CommandHandlerInterface;
use Punt\Fleet\App\Shared\Bus\CommandBusInterface;
use Punt\Fleet\Infra\Container\ContainerInterface;

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
