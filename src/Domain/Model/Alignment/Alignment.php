<?php

namespace App\Domain\Model\Alignment;

use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Tactics\TacticName;

class Alignment
{
    /** @var TacticName */
    private $tacticName;

    /** @var PlayerNumber[] */
    private $playerNumbers;

    /**
     * Alignment constructor.
     *
     * @param PlayerNumber[] $players
     */
    public function __construct(TacticName $tacticName, array $players)
    {
        $this->tacticName = $tacticName;
        $this->playerNumbers = $players;
    }

    public function getTacticName(): TacticName
    {
        return $this->tacticName;
    }

    /**
     * @return PlayerNumber[]
     */
    public function getPlayerNumbers(): array
    {
        return $this->playerNumbers;
    }
}
