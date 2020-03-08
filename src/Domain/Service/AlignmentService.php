<?php

namespace App\Domain\Service;

use App\Domain\EventDispatcher;
use App\Domain\Model\Alignment\Alignment;
use App\Domain\Model\Alignment\AlignmentGenerated;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerNotFoundException;
use App\Domain\Model\Player\PlayerRepository;
use App\Domain\Model\Tactics\TacticName;
use App\Domain\Model\Tactics\TacticRepository;
use App\Utils\PlayerSorter;

class AlignmentService
{
    /** @var PlayerRepository */
    private $playerRepository;

    /** @var TacticRepository */
    private $tacticRepository;

    /** @var EventDispatcher */
    private $eventDispatcher;

    public function __construct(
        PlayerRepository $playerRepository,
        TacticRepository $tacticRepository,
        EventDispatcher $eventDispatcher)
    {
        $this->playerRepository = $playerRepository;
        $this->tacticRepository = $tacticRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getAlignmentByTacticName(TacticName $tacticName): Alignment
    {
        $tactic = $this->tacticRepository->findTacticByName($tacticName);

        /** @var Player[] $availablePlayers */
        $availablePlayers = PlayerSorter::sortByScore($this->playerRepository->findAll());

        $alignedPlayers = [];

        foreach ($tactic->getPlayerRoles() as $position) {
            $player = null;

            foreach ($availablePlayers as $key => $availablePlayer) {
                if ($position == $availablePlayer->getRole()) {
                    $player = $availablePlayer;
                    unset($availablePlayers[$key]);
                    break;
                }
            }

            if (null === $player) {
                throw new PlayerNotFoundException(sprintf("Player with role '%s' not found", $position->role()));
            }
            $alignedPlayers[] = $player->getNumber();
        }

        $alignment = new Alignment($tactic->getTacticName(), $alignedPlayers);

        // TODO: Queries generando eventos ????
        $this->eventDispatcher->dispatch(AlignmentGenerated::fromAlignment($alignment));

        return $alignment;
    }
}
