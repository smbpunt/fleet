<?php

declare(strict_types=1);

namespace App\Application\Command\Fleet\Register;

use App\Application\Command\CommandInterface;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: RegisterFleetCommand::class)]
readonly class RegisterFleetCommandHandler implements CommandHandlerInterface
{
    public function __construct(private PsrContainerInterface $container) {}

    /**
     * @param RegisterFleetCommand $command
     * @return Fleet
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(CommandInterface $command): Fleet
    {
        /** @var FleetRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(FleetRepositoryInterface::class);

        $fleet = Fleet::create($command->userId);
        $fleetRepository->save($fleet, true);

        return $fleet;
    }
}
