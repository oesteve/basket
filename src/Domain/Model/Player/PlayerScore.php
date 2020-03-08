<?php

namespace App\Domain\Model\Player;

class PlayerScore
{
    /** @var int */
    private $score;

    public function __construct(int $score)
    {
        $this->score = $score;
    }

    public function score(): int
    {
        return $this->score;
    }
}
