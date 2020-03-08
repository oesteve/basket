<?php

namespace App\Domain;

interface EventDispatcher
{
    public function dispatch(DomainEvent $event): void;
}
