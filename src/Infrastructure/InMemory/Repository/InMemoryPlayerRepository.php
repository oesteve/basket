<?php

namespace App\Infrastructure\InMemory\Repository;

use App\Domain\EventDispatcher;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerAlreadyExistsException;
use App\Domain\Model\Player\PlayerNotFoundException;
use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Player\PlayerRepository;

class InMemoryPlayerRepository implements PlayerRepository
{
    /** @var EventDispatcher */
    private $eventDispatcher;

    /** @var Player[] */
    private $players = [];

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function save(Player $player): void
    {
        $key = $player->getNumber()->number();

        if (\array_key_exists($key, $this->players)) {
            throw new PlayerAlreadyExistsException(sprintf('Another player with number %d is in the repository', $key));
        }
        $this->players[$key] = $player;

        $events = $player->getEvents();

        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function findByNumber(PlayerNumber $param): Player
    {
        $key = $param->number();

        if (!\array_key_exists($key, $this->players)) {
            throw new PlayerNotFoundException(sprintf('Player with number %d not found in the repository', $key));
        }

        return $this->players[$key];
    }

    public function findAll(): array
    {
        return array_values($this->players);
    }

    public function clear(): void
    {
        $this->players = [];
    }
}
