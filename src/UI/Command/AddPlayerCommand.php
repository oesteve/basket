<?php

namespace App\UI\Command;

use App\Application\Command\CommandBus;
use App\Application\Handler\Command\Player\AddPlayer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddPlayerCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'basket:player:add';

    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    public function configure(): void
    {
        $this->setDescription('Add new player to the app');
        $this->addArgument('number', InputArgument::REQUIRED, 'The player number, its identifier');
        $this->addArgument('name', InputArgument::REQUIRED, 'The player name');
        $this->addArgument('role', InputArgument::REQUIRED, 'The player preferred role, it should be BASE, ESCOLTA, ALERO, ALA-PIVOT, PIVOT');
        $this->addArgument('score', InputArgument::REQUIRED, 'The average trainer score');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $number = $input->getArgument('number');
        $name = $input->getArgument('name');
        $role = $input->getArgument('role');
        $score = $input->getArgument('score');

        $addPlayer = new AddPlayer((int) $number, $name, $role, (int) $score);

        $this->commandBus->dispatch($addPlayer);

        $io = new SymfonyStyle($input, $output);
        $io->success(sprintf('Player #%d %s was added successfully', $addPlayer->getNumber(), $addPlayer->getName()));

        return 0;
    }
}
