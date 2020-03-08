<?php

namespace App\Tests\UI\Command;

use App\Application\Handler\Query\Player\GetPlayerList;
use App\Domain\Model\Player\PlayerRepository;
use App\Tests\BaseTestCase;

class PlayerListCommandTest extends BaseTestCase
{
    public function testEmptyList(): void
    {
        $commandTester = $this->executeCommand('basket:player:list');

        $output = $commandTester->getDisplay();
        $this->assertContains('No players found in the database', $output);
    }

    public function testDefaultListSort(): void
    {
        /** @var PlayerRepository $playerRepository */
        $playerRepository = $this->get(PlayerRepository::class);

        foreach (static::players() as $player) {
            $playerRepository->save($player);
        }

        $commandTester = $this->executeCommand('basket:player:list');
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(0, $statusCode);
    }

    public function testListSortByScore(): void
    {
        /** @var PlayerRepository $playerRepository */
        $playerRepository = $this->get(PlayerRepository::class);

        foreach (static::players() as $player) {
            $playerRepository->save($player);
        }

        $commandTester = $this->executeCommand('basket:player:list', ['sort' => GetPlayerList::SORT_SCORE]);
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(0, $statusCode);
    }
}
