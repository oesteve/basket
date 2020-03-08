<?php

namespace App\Utils;

use App\Domain\Model\Player\PlayerRole;
use App\Domain\Model\Tactics\Tactic;
use App\Domain\Model\Tactics\TacticName;

class SampleData
{
    public static function playersData(): array
    {
        return [
            [1, 'Quino COLOM', PlayerRole::BASE, 89],
            [5, 'Rudy Fernandez', PlayerRole::ALERO, 90],
            [8, 'Paul RIBAS', PlayerRole::ESCOLTA, 91],
            [9, 'Ricky RUBIO', PlayerRole::BASE, 92],
            [10, 'Victor CLAVER', PlayerRole::ALERO, 93],
            [14, 'Willy HERNANGOMEZ GEUER', PlayerRole::PIVOT, 94],
            [18, 'Pierre ORIOLA', PlayerRole::ALA_PIVOT, 95],
            [22, 'Xavier RABASEDA', PlayerRole::ALERO, 96],
            [23, 'Sergio LLULL', PlayerRole::ESCOLTA, 97],
            [33, 'Javier BEIRAN', PlayerRole::ALERO, 98],
            [41, 'Juancho HERNANGOMEZ', PlayerRole::ALERO, 99],
        ];
    }

    /**
     * @return Tactic[]
     */
    public static function systemTactics(): array
    {
        $tactics = [];

        // Defensa 1-3-1: BASE + ESCOLTA + ESCOLTA + ALA-PIVOT + PIVOT
        $tactics[] = new Tactic(new TacticName('Defensa 1-3-1'), [
            PlayerRole::Base(),
            PlayerRole::Escolta(),
            PlayerRole::Escolta(),
            PlayerRole::AlaPivot(),
            PlayerRole::Pivot(),
        ]);

        // Defensa Zonal 2-3 : BASE + BASE + ALERO + PIVOT + ALA-PIVOT
        $tactics[] = new Tactic(new TacticName('Defensa Zonal 2-3'), [
            PlayerRole::Base(),
            PlayerRole::Base(),
            PlayerRole::Alero(),
            PlayerRole::Pivot(),
            PlayerRole::AlaPivot(),
        ]);

        // Ataque 2-2-1: BASE + ALERO + ESCOLTA + PIVOT + ALA-PIVOT
        $tactics[] = new Tactic(new TacticName('Ataque 2-2-1'), [
            PlayerRole::Base(),
            PlayerRole::Alero(),
            PlayerRole::Escolta(),
            PlayerRole::Pivot(),
            PlayerRole::AlaPivot(),
        ]);

        return $tactics;
    }
}
