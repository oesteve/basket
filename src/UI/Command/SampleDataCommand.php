<?php

namespace App\UI\Command;

use App\Application\Command\CommandBus;
use App\Application\Handler\Command\Player\AddPlayer;
use App\Utils\SampleData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SampleDataCommand extends Command
{
    protected static $defaultName = 'basket:player:sample';

    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    public function configure(): void
    {
        $this->setDescription('Add sample data to the system');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (SampleData::playersData() as $playerData) {
            $this->commandBus->dispatch(new AddPlayer(
                $playerData[0],
                $playerData[1],
                $playerData[2],
                $playerData[3]
            ));
        }

        return 0;
    }
}
