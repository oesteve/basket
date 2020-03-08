<?php

namespace App\Utils;

use App\Domain\Model\Player\Player;

class PlayerSorter
{
    /**
     * @param Player[] $players
     *
     * @return Player[]
     */
    public static function sortByNumber(array $players): array
    {
        uasort($players, function (Player $a, Player $b) {
            if ($a->getNumber() == $b->getNumber()) {
                return 0;
            }

            return ($a->getNumber()->number() < $b->getNumber()->number()) ? -1 : 1;
        });

        return array_values($players);
    }

    /**
     * @param Player[] $players
     *
     * @return Player[]
     */
    public static function sortByScore(array $players): array
    {
        uasort($players, function (Player $a, Player $b) {
            if ($a->getScore() == $b->getScore()) {
                return 0;
            }

            return ($a->getScore()->score() > $b->getScore()->score()) ? -1 : 1;
        });

        return array_values($players);
    }
}
