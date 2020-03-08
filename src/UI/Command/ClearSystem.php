<?php

namespace App\UI\Command;

use App\Application\EventStore\EventStore;
use App\Domain\Model\Player\PlayerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearSystem extends Command
{
    protected static $defaultName = 'basket:system:clear';

    /** @var EventStore */
    private $eventStore;

    /** @var PlayerRepository */
    private $playerRepository;

    public function __construct(EventStore $eventStore, PlayerRepository $playerRepository)
    {
        parent::__construct();
        $this->eventStore = $eventStore;
        $this->playerRepository = $playerRepository;
    }

    public function configure(): void
    {
        $this->addUsage('Reset system storage');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->eventStore->clear();
        $this->playerRepository->clear();

        return 0;
    }
}
