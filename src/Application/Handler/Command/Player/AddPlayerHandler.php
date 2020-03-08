<?php

namespace App\Application\Handler\Command\Player;

use App\Application\Command\CommandHandler;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Player\PlayerRepository;
use App\Domain\Model\Player\PlayerRole;
use App\Domain\Model\Player\PlayerScore;

class AddPlayerHandler implements CommandHandler
{
    /** @var PlayerRepository */
    private $repository;

    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddPlayer $addPlayer): void
    {
        $number = new PlayerNumber($addPlayer->getNumber());
        $name = $addPlayer->getName();
        $role = new PlayerRole($addPlayer->getRole());
        $score = new PlayerScore($addPlayer->getScore());

        $player = new Player($number, $name, $role, $score);

        $this->repository->save($player);
    }
}
