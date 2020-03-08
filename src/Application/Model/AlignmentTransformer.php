<?php

namespace App\Application\Model;

use App\Domain\Model\Alignment\Alignment;
use App\Domain\Model\Player\PlayerRepository;

class AlignmentTransformer
{
    /** @var PlayerRepository */
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function fromAlignment(Alignment $alignment): AlignmentDto
    {
        $listPlayers = [];

        foreach ($alignment->getPlayerNumbers() as $playerNumber) {
            $player = $this->playerRepository->findByNumber($playerNumber);

            $playerList = new PlayerDto(
                $player->getNumber()->number(),
                $player->getName(),
                $player->getRole()->role(),
                $player->getScore()->score()
            );

            $listPlayers[] = $playerList;
        }

        return new AlignmentDto($alignment->getTacticName()->name(), $listPlayers);
    }
}
