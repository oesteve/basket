<?php

namespace App\Tests\Application\Handler\Query\Alignment;

use App\Application\EventStore\EventStore;
use App\Application\Exception\ValidationException;
use App\Application\Handler\Query\Alignment\GetAlignment;
use App\Application\Query\QueryBus;
use App\Domain\Model\Alignment\AlignmentGenerated;
use App\Tests\BaseTestCase;

class GetAlignmentTest extends BaseTestCase
{
    public function testValidationError(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);
        $this->expectException(ValidationException::class);
        $queryBus->query(new GetAlignment(''));
    }

    public function testGetAlignment(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);
        /** @var EventStore $eventStore */
        $eventStore = $this->get(EventStore::class);

        $this->addTestPlayers();
        $eventStore->clear();

        $alignment = $queryBus->query(new GetAlignment('Defensa 1-3-1'));

        $this->assertNotNull($alignment);

        $events = $eventStore->getEventsFrom(0);
        $this->assertCount(1, $events);

        $this->assertEquals(AlignmentGenerated::class, $events[0]->getClass());
    }
}
