<?php

namespace App\Application\EventStore;

class StoredEvent
{
    /** @var int */
    private $position;

    /** @var \DateTime */
    private $occurredAt;

    /** @var string */
    private $class;

    /** @var string */
    private $event;

    public function __construct(int $position, \DateTime $occurredAt, string $class, string $event)
    {
        $this->position = $position;
        $this->occurredAt = $occurredAt;
        $this->class = $class;
        $this->event = $event;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getOccurredAt(): \DateTime
    {
        return $this->occurredAt;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
