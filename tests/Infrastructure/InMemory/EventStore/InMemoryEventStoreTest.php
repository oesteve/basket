<?php

namespace App\Tests\Infrastructure\InMemory\EventStore;

use App\Application\EventStore\EventStore;
use App\Infrastructure\InMemory\EventStore\InMemoryEventStore;
use App\Tests\Application\EventStore\EventStoreTest;

class InMemoryEventStoreTest extends EventStoreTest
{
    protected function getEmptyEventStore(): EventStore
    {
        /** @var InMemoryEventStore $eventStore */
        $eventStore = $this->get(InMemoryEventStore::class);

        return $eventStore;
    }
}
