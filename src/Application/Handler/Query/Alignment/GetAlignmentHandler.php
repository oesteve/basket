<?php

namespace App\Application\Handler\Query\Alignment;

use App\Application\Model\AlignmentDto;
use App\Application\Model\AlignmentTransformer;
use App\Application\Query\QueryHandler;
use App\Domain\Model\Tactics\TacticName;
use App\Domain\Service\AlignmentService;

class GetAlignmentHandler implements QueryHandler
{
    /** @var AlignmentService */
    private $alignmentService;

    /** @var AlignmentTransformer */
    private $alignmentTransformer;

    public function __construct(AlignmentService $alignmentService, AlignmentTransformer $alignmentTransformer)
    {
        $this->alignmentService = $alignmentService;
        $this->alignmentTransformer = $alignmentTransformer;
    }

    public function __invoke(GetAlignment $getAlignment): AlignmentDto
    {
        $tacticName = new TacticName($getAlignment->getTacticName());

        $alignment = $this->alignmentService->getAlignmentByTacticName($tacticName);

        return $this->alignmentTransformer->fromAlignment($alignment);
    }
}
