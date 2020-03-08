<?php

namespace App\Infrastructure\Filesystem\Repository;

use App\Domain\EventDispatcher;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerAlreadyExistsException;
use App\Domain\Model\Player\PlayerNotFoundException;
use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Player\PlayerRepository;

/**
 * InMemoryRepository decorator with filesystem persist support.
 */
class FilesystemPlayerRepository implements PlayerRepository
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /** @var Player[] */
    private $players = [];

    public function __construct(string $filesystemDatabasePath, EventDispatcher $eventDispatcher)
    {
        $this->path = sprintf('%s/%s', $filesystemDatabasePath, 'players');
        $this->eventDispatcher = $eventDispatcher;
        $this->read();
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

        $this->persist();
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

    private function read(): void
    {
        if (!file_exists($this->path)) {
            return;
        }

        $content = file_get_contents($this->path);
        $data = unserialize($content, ['allowed_classes' => true]);

        $this->players = $data;
    }

    private function persist(): void
    {
        $content = serialize($this->players);
        file_put_contents($this->path, $content);
    }

    public function clear(): void
    {
        $this->players = [];
        $this->persist();
    }
}
