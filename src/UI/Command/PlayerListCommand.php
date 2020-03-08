<?php

namespace App\UI\Command;

use App\Application\Handler\Query\Player\GetPlayerList;
use App\Application\Model\PlayerDto;
use App\Application\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PlayerListCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'basket:player:list';

    /** @var QueryBus */
    private $queryBus;

    public function __construct(QueryBus $commandBus)
    {
        parent::__construct();
        $this->queryBus = $commandBus;
    }

    public function configure(): void
    {
        $this->setDescription('List the full list of players');
        $this->addArgument('sort', InputArgument::OPTIONAL, 'sort option dorsal|puntuacion', GetPlayerList::SORT_NUMBER);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $sort = $input->getArgument('sort');

        $getPlayerList = new GetPlayerList((string) $sort);

        $playerList = $this->queryBus->query($getPlayerList);

        if (empty($playerList)) {
            $io->note('No players found in the database');

            return 0;
        }

        $data = array_map(function (PlayerDto $player) {
            return $player->toArray();
        }, $playerList);

        $io->table(['#', 'Name', 'Role', 'Score'], $data);

        return 0;
    }
}
