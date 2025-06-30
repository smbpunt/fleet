<?php

declare(strict_types=1);

namespace Punt\Fleet\App\Command\Fleet\Register;

use Punt\Fleet\App\Command\CommandInterface;
use Punt\Fleet\App\Command\CommandHandlerInterface;
use Punt\Fleet\Domain\Model\Fleet;
use Punt\Fleet\Domain\Repository\FleetRepositoryInterface;
use Punt\Fleet\Infra\Container\ContainerInterface;

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
