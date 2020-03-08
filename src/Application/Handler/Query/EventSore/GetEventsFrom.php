<?php

namespace App\Application\Handler\Query\EventSore;

use App\Application\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;

class GetEventsFrom implements Query
{
    /**
     * @Assert\PositiveOrZero
     *
     * @var int
     */
    private $position;

    public function __construct(int $position)
    {
        $this->position = $position;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
