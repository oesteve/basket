<?php

namespace App\Tests\Infrastructure\Filesystem\Repository;

use App\Application\EventStore\EventStore;
use App\Domain\EventDispatcher;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerAlreadyExistsException;
use App\Domain\Model\Player\PlayerCreated;
use App\Domain\Model\Player\PlayerNotFoundException;
use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Player\PlayerRepository;
use App\Domain\Model\Player\PlayerRole;
use App\Domain\Model\Player\PlayerScore;
use App\Infrastructure\Filesystem\Repository\FilesystemPlayerRepository;
use App\Tests\BaseTestCase;

class FilesystemPlayerRepositoryTest extends BaseTestCase
{
    public function testPersistDuplicatedPlayerError(): void
    {
        $repository = $this->getEmptyRepository();

        $player = new Player(new PlayerNumber(12), 'a player', PlayerRole::Base(), new PlayerScore(4));
        $repository->save($player);

        $newPlayer = new Player(new PlayerNumber(12), 'a player', PlayerRole::Base(), new PlayerScore(4));

        $this->expectException(PlayerAlreadyExistsException::class);
        $repository->save($newPlayer);
    }

    public function testUserNotFoundError(): void
    {
        $repository = $this->getEmptyRepository();

        $this->expectException(PlayerNotFoundException::class);
        $repository->findByNumber(new PlayerNumber(0));
    }

    public function testPersistPlayer(): void
    {
        $repository = $this->getEmptyRepository();

        $player = new Player(new PlayerNumber(12), 'a player', PlayerRole::Base(), new PlayerScore(4));
        $repository->save($player);

        $player = $repository->findByNumber(new PlayerNumber(12));

        $this->assertNotNull($player);
    }

    public function testFindAll(): void
    {
        $repository = $this->getEmptyRepository();

        $player = new Player(new PlayerNumber(12), 'a player', PlayerRole::Base(), new PlayerScore(4));
        $repository->save($player);

        $players = $repository->findAll();

        $this->assertCount(1, $players);
    }

    public function testEventGeneration(): void
    {
        /** @var EventStore $eventStore */
        $eventStore = $this->get(EventStore::class);

        $repository = $this->getEmptyRepository();

        $player = new Player(new PlayerNumber(12), 'a player', PlayerRole::Base(), new PlayerScore(4));
        $repository->save($player);

        $events = $eventStore->getEventsFrom(0);
        $this->assertCount(1, $events);

        $event = $events[0];

        $this->assertEquals(PlayerCreated::class, $event->getClass());
    }

    private function getEmptyRepository(): PlayerRepository
    {
        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->get(EventDispatcher::class);

        $repository = new FilesystemPlayerRepository(sys_get_temp_dir(), $eventDispatcher);
        $repository->clear();

        return $repository;
    }
}
