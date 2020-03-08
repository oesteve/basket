<?php

namespace App\Infrastructure\SfEventDispatcher\EventDispatcher;

use App\Domain\DomainEvent;
use App\Domain\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SfEventDispatcher implements EventDispatcher
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->eventDispatcher->dispatch($event, DomainEvent::class);
        $this->eventDispatcher->dispatch($event);
    }
}
