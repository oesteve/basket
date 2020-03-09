<?php

namespace App\Infrastructure\Filesystem\EventStore;

use App\Application\EventStore\EventStore;
use App\Application\EventStore\StoredEvent;
use App\Domain\DomainEvent;
use Symfony\Component\Serializer\SerializerInterface;

class FilesystemEventStore implements EventStore
{
    /** @var StoredEvent[] */
    private $events = [];
    /** @var SerializerInterface */
    private $serializer;
    /** @var string */
    private $path;

    public function __construct(string $filesystemDatabasePath, SerializerInterface $serializer)
    {
        if(!is_dir($filesystemDatabasePath)){
            if (!mkdir($filesystemDatabasePath, 0755,true) && !is_dir($filesystemDatabasePath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $filesystemDatabasePath));
            }
        }

        $this->path = sprintf('%s/%s', $filesystemDatabasePath, 'event_store');
        $this->serializer = $serializer;
        $this->read();
    }

    public function store(DomainEvent $domainEvent): void
    {
        $occurredAt = $domainEvent->getOccurredAt();
        $class = \get_class($domainEvent);
        $event = $this->serializer->serialize($domainEvent, 'json');

        $position = \count($this->events);

        $this->events[] = new StoredEvent($position, $occurredAt, $class, $event);
        $this->persist();
    }

    /**
     * @return StoredEvent[]
     */
    public function getEventsFrom(int $position = 0): array
    {
        return \array_slice($this->events, $position);
    }

    private function read(): void
    {
        if (!file_exists($this->path)) {
            return;
        }

        $content = file_get_contents($this->path);
        $data = unserialize($content, ['allowed_classes' => true]);

        $this->events = $data;
    }

    private function persist(): void
    {
        $content = serialize($this->events);
        file_put_contents($this->path, $content);
    }

    public function clear(): void
    {
        $this->events = [];
        $this->persist();
    }
}
