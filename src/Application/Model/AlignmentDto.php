<?php

namespace App\Application\Model;

class AlignmentDto
{
    /** @var string */
    private $name;

    /** @var PlayerDto[] */
    private $players;

    /**
     * @param PlayerDto[] $players
     */
    public function __construct(string $name, array $players)
    {
        $this->name = $name;
        $this->players = $players;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return PlayerDto[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }
}
