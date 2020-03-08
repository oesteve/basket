<?php

namespace App\Domain\Model;

use App\Domain\DomainEvent;

trait EntityEventCollector
{
    /** @var DomainEvent[] */
    private $events = [];

    protected function addEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
