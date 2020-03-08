<?php

namespace App\Tests\Application\Handler\Event\EventStore;

use App\Application\EventStore\EventStore;
use App\Application\EventStore\StoredEvent;
use App\Domain\EventDispatcher;
use App\Tests\BaseTestCase;
use App\Tests\Infrastructure\InMemory\EventStore\TestEvent;

class EventStoreHandlerTest extends BaseTestCase
{
    public function testEventStoreHandler()
    {
        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->get(EventDispatcher::class);
        /** @var EventStore $eventStore */
        $eventStore = $this->get(EventStore::class);

        $eventDispatcher->dispatch(new TestEvent(new \DateTime('2020-03-08T11:29:02+00:00')));

        $events = $eventStore->getEventsFrom(0);
        $this->assertCount(1, $events);
        $this->assertInstanceOf(StoredEvent::class, $events[0]);
    }
}
