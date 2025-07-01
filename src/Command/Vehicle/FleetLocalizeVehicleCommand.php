<?php

declare(strict_types=1);

namespace App\Command\Vehicle;

use App\Application\Command\Vehicle\Park\ParkVehicleCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'fleet:localize-vehicle',
    description: 'Set vehicle location (park vehicle)',
)]
class FleetLocalizeVehicleCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('plateNumber', InputArgument::REQUIRED, 'The vehicle plate number')
            ->addArgument('lat', InputArgument::REQUIRED, 'Latitude coordinate')
            ->addArgument('lng', InputArgument::REQUIRED, 'Longitude coordinate')
            ->addArgument('alt', InputArgument::OPTIONAL, 'Altitude coordinate');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $parkVehicleCommand = new ParkVehicleCommand(
            $input->getArgument('plateNumber'),
            (float)$input->getArgument('lat'),
            (float)$input->getArgument('lng'),
            $input->getArgument('alt') ? (float)$input->getArgument('alt') : null
        );

        try {
            $this->bus->dispatch($parkVehicleCommand);
        } catch (ExceptionInterface $e) {
            $io->error('Failed to localize vehicle: ' . $e->getMessage());

            return Command::FAILURE;
        }

        $io->success('Vehicle ' . $input->getArgument('plateNumber') . ' localized successfully');

        return Command::SUCCESS;
    }
}
