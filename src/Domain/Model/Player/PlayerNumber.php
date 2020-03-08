<?php

namespace App\Domain\Model\Player;

class PlayerNumber
{
    /** @var int */
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function number(): int
    {
        return $this->number;
    }
}
