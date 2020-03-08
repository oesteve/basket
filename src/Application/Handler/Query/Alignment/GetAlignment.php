<?php

namespace App\Application\Handler\Query\Alignment;

use App\Application\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;

class GetAlignment implements Query
{
    /**
     * @Assert\NotBlank
     *
     * @var string
     */
    private $tacticName;

    public function __construct(string $tacticName)
    {
        $this->tacticName = $tacticName;
    }

    public function getTacticName(): string
    {
        return $this->tacticName;
    }
}
