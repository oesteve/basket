<?php

namespace App\Application\Handler\Query\Player;

use App\Application\Model\PlayerDto;
use App\Application\Query\QueryHandler;
use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerRepository;
use App\Utils\PlayerSorter;

class GetPlayerListHandler implements QueryHandler
{
    /** @var PlayerRepository */
    private $repository;

    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return PlayerDto[]
     */
    public function __invoke(GetPlayerList $getPlayerList): array
    {
        $players = $this->repository->findAll();

        if (GetPlayerList::SORT_NUMBER === $getPlayerList->getSortBy()) {
            $players = PlayerSorter::sortByNumber($players);
        } else {
            $players = PlayerSorter::sortByScore($players);
        }

        // Return an application layer DTOs
        return array_map(static function (Player $player) {
            return PlayerDto::fromPlayer($player);
        }, $players);
    }
}
