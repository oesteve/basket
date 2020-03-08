<?php

namespace App\Application\Model;

use App\Domain\Model\Player\Player;

class PlayerDto
{
    /** @var int */
    private $number;
    /** @var string */
    private $name;
    /** @var string */
    private $role;
    /** @var int */
    private $score;

    public function __construct(int $number, string $name, string $role, int $score)
    {
        $this->number = $number;
        $this->name = $name;
        $this->role = $role;
        $this->score = $score;
    }

    public static function fromPlayer(Player $player): self
    {
        return new self(
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

    /**
     * @return array<string,string|int>
     */
    public function toArray(): array
    {
        return [
            'number' => $this->getNumber(),
            'name' => $this->getName(),
            'role' => $this->getRole(),
            'score' => $this->getScore(),
        ];
    }
}
