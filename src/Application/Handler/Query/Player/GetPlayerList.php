<?php

namespace App\Application\Handler\Query\Player;

use App\Application\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;

class GetPlayerList implements Query
{
    const SORT_NUMBER = 'dorsal';
    const SORT_SCORE = 'puntuacion';

    /**
     * @Assert\Choice(callback={"App\Application\Handler\Query\Player\GetPlayerList", "sortOptions"})
     *
     * @var string
     */
    private $sortBy;

    public function __construct(string $sortBy)
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return string[]
     */
    public static function sortOptions(): array
    {
        return [self::SORT_SCORE, self::SORT_NUMBER];
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }
}
