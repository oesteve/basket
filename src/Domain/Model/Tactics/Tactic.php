<?php

namespace App\Domain\Model\Tactics;

use App\Domain\Model\Player\PlayerRole;

class Tactic
{
    /** @var TacticName */
    private $name;

    /** @var PlayerRole[] */
    private $playerRoles;

    /**
     * @param PlayerRole[] $playerRoles
     */
    public function __construct(TacticName $tacticName, array $playerRoles)
    {
        $this->name = $tacticName;
        $this->playerRoles = $playerRoles;
    }

    public function getTacticName(): TacticName
    {
        return $this->name;
    }

    /**
     * @return PlayerRole[]
     */
    public function getPlayerRoles(): array
    {
        return $this->playerRoles;
    }
}
