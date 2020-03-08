<?php

namespace App\Domain\Model\Alignment;

use App\Domain\DomainEvent;
use App\Domain\Model\Player\PlayerNumber;

class AlignmentGenerated extends DomainEvent
{
    /** @var string */
    private $tacticName;

    /** @var int[] */
    private $playerNumber;

    /**
     * @param int[] $playerNumber
     */
    public function __construct(\DateTime $occurredAt, string $tacticName, array $playerNumber)
    {
        parent::__construct($occurredAt);
        $this->tacticName = $tacticName;
        $this->playerNumber = $playerNumber;
    }

    public static function fromAlignment(Alignment $alignment): self
    {
        $playerNumbers = array_map(function (PlayerNumber $playerNumber) {
            return $playerNumber->number();
        }, $alignment->getPlayerNumbers());

        return new self(new \DateTime(), $alignment->getTacticName()->name(), $playerNumbers);
    }

    public function getTacticName(): string
    {
        return $this->tacticName;
    }

    /**
     * @return int[]
     */
    public function getPlayerNumber(): array
    {
        return $this->playerNumber;
    }
}
