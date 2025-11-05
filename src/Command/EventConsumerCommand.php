<?php

namespace App\Command;

use App\Consumer\FootballEventConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EventConsumerCommand extends Command
{
    private bool $shouldStop = false;

    public function __construct(private FootballEventConsumer $footballEventConsumer)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('consumer:events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Command starting... Press Ctrl+C to stop.');

        try {
            while (true) {
                $message = $this->footballEventConsumer->consume();

                if ($message !== null) {
                    $output->writeln('Processed event: ' . $message);
                }
            }
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
