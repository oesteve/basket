<?php

namespace App\Tests\Application\EventStore;

use App\Application\EventStore\EventStore;
use App\Application\EventStore\StoredEvent;
use App\Infrastructure\InMemory\EventStore\InMemoryEventStore;
use App\Tests\BaseTestCase;
use App\Tests\Infrastructure\InMemory\EventStore\TestEvent;

abstract class EventStoreTest extends BaseTestCase
{
    public function testPersistEvent()
    {
        /** @var InMemoryEventStore $eventStore */
        $eventStore = $this->getEmptyEventStore();

        $event = new TestEvent(new \DateTime('2020-03-08T11:29:02+00:00'));
        $eventStore->store($event);

        /** @var StoredEvent[] $retrievedEvents */
        $retrievedEvents = $eventStore->getEventsFrom(0);

        $this->assertCount(1, $retrievedEvents);
        $this->assertEquals(TestEvent::class, $retrievedEvents[0]->getClass());
        $this->assertEquals($event->getOccurredAt(), $retrievedEvents[0]->getOccurredAt());
    }

    abstract protected function getEmptyEventStore(): EventStore;
}
