<?php

namespace App\UI\Command;

use App\Application\Handler\Query\Alignment\GetAlignment;
use App\Application\Model\AlignmentDto;
use App\Application\Model\PlayerDto;
use App\Application\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AlignmentGenerateCommand extends Command
{
    protected static $defaultName = 'basket:alignment:generate';

    /** @var QueryBus */
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
    }

    public function configure(): void
    {
        $this->setDescription('Generate an alignment from tactic name');
        $this->addArgument('tactic', InputArgument::REQUIRED, 'The tactic name');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $tacticName = $input->getArgument('tactic');
        /** @var AlignmentDto $alignment */
        $alignment = $this->queryBus->query(new GetAlignment($tacticName));

        $io = new SymfonyStyle($input, $output);
        $io->title(sprintf('Tactic name: %s ', $alignment->getName()));
        $data = array_map(function (PlayerDto $player) {
            return $player->toArray();
        }, $alignment->getPlayers());

        $io->table(['#', 'Name', 'Role', 'Score'], $data);

        return 0;
    }
}
