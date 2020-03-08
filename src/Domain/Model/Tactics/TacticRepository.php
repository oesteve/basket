<?php

namespace App\Domain\Model\Tactics;

interface TacticRepository
{
    public function findTacticByName(TacticName $tacticName): Tactic;

    public function add(Tactic $tactic): void;
}
