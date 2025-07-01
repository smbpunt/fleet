<?php

declare(strict_types=1);

namespace App\Command\Fleet;

use App\Application\Command\Fleet\Register\RegisterFleetCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'fleet:create',
    description: 'Create a new fleet for a user',
)]
class FleetCreateCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('userId', InputArgument::REQUIRED, 'The user ID for whom to create the fleet');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $registerFleetCommand = new RegisterFleetCommand($input->getArgument('userId'));
        try {
            $this->bus->dispatch($registerFleetCommand);
        } catch (ExceptionInterface $e) {
            $io->error('Failed to create fleet: ' . $e->getMessage());

            return Command::FAILURE;
        }
        $io->success('Fleet created successfully for user: ' . $input->getArgument('userId'));

        return Command::SUCCESS;
    }
}
