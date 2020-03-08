<?php

namespace App\Application\Handler\Event\EventStore;

use App\Application\EventStore\EventStore;
use App\Domain\DomainEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventStoreHandler implements EventSubscriberInterface
{
    /** @var EventStore */
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function handle(DomainEvent $domainEvent): void
    {
        $this->eventStore->store($domainEvent);
    }

    /**
     * @return array<string,string>
     */
    public static function getSubscribedEvents(): array
    {
        return [DomainEvent::class => 'handle'];
    }
}
