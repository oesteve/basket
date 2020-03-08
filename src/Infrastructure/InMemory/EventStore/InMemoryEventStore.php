<?php

namespace App\Infrastructure\InMemory\EventStore;

use App\Application\EventStore\EventStore;
use App\Application\EventStore\StoredEvent;
use App\Domain\DomainEvent;
use Symfony\Component\Serializer\SerializerInterface;

class InMemoryEventStore implements EventStore
{
    /** @var StoredEvent[] */
    private $events = [];
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function store(DomainEvent $domainEvent): void
    {
        $occurredAt = $domainEvent->getOccurredAt();
        $class = \get_class($domainEvent);
        $event = $this->serializer->serialize($domainEvent, 'json');
        $position = \count($this->events);

        $this->events[] = new StoredEvent($position, $occurredAt, $class, $event);
    }

    /**
     * @return StoredEvent[]
     */
    public function getEventsFrom(int $position = 0): array
    {
        return \array_slice($this->events, $position);
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
