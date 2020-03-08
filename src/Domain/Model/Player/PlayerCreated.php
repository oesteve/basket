<?php

namespace App\Domain\Model\Player;

use App\Domain\DomainEvent;

class PlayerCreated extends DomainEvent
{
    /** @var int */
    private $number;

    /** @var string */
    private $name;

    /** @var string */
    private $role;

    /** @var int */
    private $score;

    public function __construct(\DateTime $occurredAt, int $number, string $name, string $role, int $score)
    {
        parent::__construct($occurredAt);
        $this->number = $number;
        $this->name = $name;
        $this->role = $role;
        $this->score = $score;
    }

    public static function fromPlayer(Player $player): self
    {
        return new self(
            new \DateTime(),
            $player->getNumber()->number(),
            $player->getName(),
            $player->getRole()->role(),
            $player->getScore()->score()
        );
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
