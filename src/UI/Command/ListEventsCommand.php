<?php

namespace App\UI\Command;

use App\Application\EventStore\StoredEvent;
use App\Application\Handler\Query\EventSore\GetEventsFrom;
use App\Application\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListEventsCommand extends Command
{
    protected static $defaultName = 'basket:events:list';

    /** @var QueryBus */
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
    }

    public function configure(): void
    {
        $this->addUsage('List all stored events');
        $this->addArgument('position', null, 'event offset position', '0');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $position = $input->getArgument('position');

        $getEventsFromPosition = new GetEventsFrom((int) $position);

        $domainEvents = $this->queryBus->query($getEventsFromPosition);

        if (empty($domainEvents)) {
            $io->note('No events found in the event store');

            return 0;
        }

        $data = array_map(function (StoredEvent $event) {
            return [
                $event->getPosition(),
                $event->getOccurredAt()->format('Y-m-d H:i:s'),
                $event->getClass(),
                $event->getEvent(),
            ];
        }, $domainEvents);

        $io->table(['Position', 'Occurred at', 'Event name', 'Event'], $data);

        return 0;
    }
}
