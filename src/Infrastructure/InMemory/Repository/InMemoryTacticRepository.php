<?php

namespace App\Infrastructure\InMemory\Repository;

use App\Domain\Model\Tactics\Tactic;
use App\Domain\Model\Tactics\TacticName;
use App\Domain\Model\Tactics\TacticRepository;
use App\Utils\SampleData;

class InMemoryTacticRepository implements TacticRepository
{
    /** @var Tactic[] */
    private $tactics = [];

    public function __construct()
    {
        foreach (SampleData::systemTactics() as $tactic) {
            $this->add($tactic);
        }
    }

    public function findTacticByName(TacticName $tacticName): Tactic
    {
        $key = $tacticName->name();

        if (!\array_key_exists($key, $this->tactics)) {
            throw new TacticNotFoundException(sprintf('Tactic with name %s not found', $tacticName->name()));
        }

        return $this->tactics[$key];
    }

    public function add(Tactic $tactic): void
    {
        $this->tactics[$tactic->getTacticName()->name()] = $tactic;
    }
}
