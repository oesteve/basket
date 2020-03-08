<?php

namespace App\Domain;

abstract class DomainEvent
{
    /** @var \DateTime */
    private $occurredAt;

    public function __construct(\DateTime $occurredAt)
    {
        $this->occurredAt = $occurredAt;
    }

    public function getOccurredAt(): \DateTime
    {
        return $this->occurredAt;
    }
}
