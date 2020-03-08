<?php

namespace App\Application\EventStore;

use App\Domain\DomainEvent;

interface EventStore
{
    public function store(DomainEvent $domainEvent): void;

    /**
     * @return StoredEvent[]
     */
    public function getEventsFrom(int $position = 0): array;

    public function clear(): void;
}
