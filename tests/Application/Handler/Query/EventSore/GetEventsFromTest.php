<?php

namespace App\Tests\Application\Handler\Query\EventSore;

use App\Application\EventStore\StoredEvent;
use App\Application\Exception\ValidationException;
use App\Application\Handler\Query\EventSore\GetEventsFrom;
use App\Application\Query\QueryBus;
use App\Domain\EventDispatcher;
use App\Tests\BaseTestCase;
use App\Tests\Infrastructure\InMemory\EventStore\TestEvent;

class GetEventsFromTest extends BaseTestCase
{
    public function testInvalidParamError(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $this->expectException(ValidationException::class);
        $queryBus->query(new GetEventsFrom(-1));
    }

    public function testGetEmptyResponse(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $storedEvents = $queryBus->query(new GetEventsFrom(0));

        $this->assertCount(0, $storedEvents);
    }

    public function testEventsFromPosition(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);
        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->get(EventDispatcher::class);

        $eventDispatcher->dispatch(new TestEvent(new \DateTime('2020-03-08T12:48:48+00:00')));

        /** @var StoredEvent[] $storedEvents */
        $storedEvents = $queryBus->query(new GetEventsFrom(0));

        $this->assertCount(1, $storedEvents);
        $this->assertInstanceOf(StoredEvent::class, $storedEvents[0]);
        $this->assertEquals(TestEvent::class, $storedEvents[0]->getClass());
    }
}
