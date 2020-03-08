<?php

namespace App\Tests\Infrastructure\Filesystem\EventStore;

use App\Application\EventStore\EventStore;
use App\Infrastructure\Filesystem\EventStore\FilesystemEventStore;
use App\Tests\Application\EventStore\EventStoreTest;

class FilesystemEventStoreTest extends EventStoreTest
{
    protected function getEmptyEventStore(): EventStore
    {
        /** @var FilesystemEventStore $eventStore */
        $eventStore = $this->get(FilesystemEventStore::class);
        $eventStore->clear();

        return $eventStore;
    }
}
