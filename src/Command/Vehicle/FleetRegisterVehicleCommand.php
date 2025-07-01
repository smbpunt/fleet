<?php

declare(strict_types=1);

namespace App\Command\Vehicle;

use App\Application\Command\Vehicle\Register\RegisterVehicleCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'fleet:register-vehicle',
    description: 'Register a vehicle to a fleet',
)]
class FleetRegisterVehicleCommand extends Command
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
            ->addArgument('userId', InputArgument::REQUIRED, 'The user ID who owns the fleet')
            ->addArgument('plateNumber', InputArgument::REQUIRED, 'The vehicle plate number to register');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $registerVehicleCommand = new RegisterVehicleCommand(
            $input->getArgument('userId'),
            $input->getArgument('plateNumber')
        );

        try {
            $this->bus->dispatch($registerVehicleCommand);
        } catch (ExceptionInterface $e) {
            $io->error('Failed to register vehicle: ' . $e->getMessage());

            return Command::FAILURE;
        }

        $io->success('Vehicle ' . $input->getArgument('plateNumber') . ' registered successfully to fleet for user ' . $input->getArgument('userId'));

        return Command::SUCCESS;
    }
}
