<?php

namespace App\Tests\Application\Handler\Query\Player;

use App\Application\Exception\ValidationException;
use App\Application\Handler\Query\Player\GetPlayerList;
use App\Application\Model\PlayerDto;
use App\Application\Query\QueryBus;
use App\Tests\BaseTestCase;

class GetPlayerListTest extends BaseTestCase
{
    public function testValidationError(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        try {
            $queryBus->query(new GetPlayerList('nombre'));
            $this->fail('Exception should has been thrown');
        } catch (ValidationException $validationException) {
            $this->assertCount(1, $validationException->getFieldExceptions());
        }
    }

    public function testGetPlayersByNumber(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $this->addTestPlayers();

        /** @var PlayerDto[] $playerList */
        $playerList = $queryBus->query(new GetPlayerList(GetPlayerList::SORT_NUMBER));

        $this->assertCount(11, $playerList);

        $this->assertEquals(1, $playerList[0]->getNumber());
        $this->assertEquals(5, $playerList[1]->getNumber());
        $this->assertEquals(8, $playerList[2]->getNumber());
        $this->assertEquals(9, $playerList[3]->getNumber());
        $this->assertEquals(10, $playerList[4]->getNumber());
    }

    public function testGetPlayersByScore(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $this->addTestPlayers();

        /** @var PlayerDto[] $playerList */
        $playerList = $queryBus->query(new GetPlayerList(GetPlayerList::SORT_SCORE));

        $this->assertCount(11, $playerList);

        $this->assertEquals(99, $playerList[0]->getScore());
        $this->assertEquals(98, $playerList[1]->getScore());
        $this->assertEquals(97, $playerList[2]->getScore());
        $this->assertEquals(96, $playerList[3]->getScore());
        $this->assertEquals(95, $playerList[4]->getScore());
    }
}
