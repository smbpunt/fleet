<?php

declare(strict_types=1);

namespace App\Application\Command\Fleet\Register;

use App\Application\Command\CommandInterface;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Infra\Container\ContainerInterface;

readonly class RegisterFleetCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param RegisterFleetCommand $command
     * @return Fleet
     */
    public function __invoke(CommandInterface $command): Fleet
    {
        /** @var FleetRepositoryInterface $fleetRepository */
        $fleetRepository = $this->container->get(FleetRepositoryInterface::class);

        $fleet = Fleet::create($command->userId);
        $fleetRepository->save($fleet);

        return $fleet;
    }
}
