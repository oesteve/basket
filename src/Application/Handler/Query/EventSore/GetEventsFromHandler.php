<?php

namespace App\Application\Handler\Query\EventSore;

use App\Application\EventStore\EventStore;
use App\Application\Query\QueryHandler;
use App\Domain\DomainEvent;

class GetEventsFromHandler implements QueryHandler
{
    /** @var EventStore */
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @return DomainEvent[]
     */
    public function __invoke(GetEventsFrom $eventsFrom): array
    {
        return $this->eventStore->getEventsFrom($eventsFrom->getPosition());
    }
}
