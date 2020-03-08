<?php

namespace App\Domain\Model\Player;

use App\Domain\Model\EntityEventCollector;

class Player
{
    /** @var PlayerNumber */
    private $number;

    /** @var string */
    private $name;

    /** @var PlayerRole */
    private $role;

    /** @var PlayerScore */
    private $score;

    use EntityEventCollector;

    public function __construct(PlayerNumber $number, string $name, PlayerRole $role, PlayerScore $score)
    {
        $this->number = $number;
        $this->name = $name;
        $this->role = $role;
        $this->score = $score;

        $this->addEvent(PlayerCreated::fromPlayer($this));
    }

    public function getNumber(): PlayerNumber
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): PlayerRole
    {
        return $this->role;
    }

    public function getScore(): PlayerScore
    {
        return $this->score;
    }
}
