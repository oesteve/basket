<?php

namespace App\Domain\Model\Player;

interface PlayerRepository
{
    /**
     * @throws PlayerAlreadyExistsException
     */
    public function save(Player $player): void;

    /**
     * @throws PlayerNotFoundException
     */
    public function findByNumber(PlayerNumber $param): Player;

    /**
     * @return Player[]
     */
    public function findAll(): array;

    public function clear(): void;
}
