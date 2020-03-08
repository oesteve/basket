<?php

namespace App\Tests\Application\Handler\Command\Player;

use App\Application\Command\CommandBus;
use App\Application\Exception\ValidationException;
use App\Application\Handler\Command\Player\AddPlayer;
use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Player\PlayerRepository;
use App\Domain\Model\Player\PlayerRole;
use App\Tests\BaseTestCase;

class AddPlayerTest extends BaseTestCase
{
    public function testValidationError(): void
    {
        /** @var CommandBus $commandBus */
        $commandBus = $this->get(CommandBus::class);

        try {
            $commandBus->dispatch(new AddPlayer(-1, 'a', 'defensa', '1000'));
            $this->fail('Exception should has been thrown');
        } catch (ValidationException $validationException) {
            $this->assertCount(4, $validationException->getFieldExceptions());
        }
    }

    public function testAddPlayer(): void
    {
        /** @var CommandBus $commandBus */
        $commandBus = $this->get(CommandBus::class);
        /** @var PlayerRepository $repository */
        $repository = $this->get(PlayerRepository::class);

        $addPlayer = new AddPlayer(99, 'Pau', PlayerRole::ALA_PIVOT, '100');
        $commandBus->dispatch($addPlayer);

        $player = $repository->findByNumber(new PlayerNumber(99));
        $this->assertNotNull($player);

        $this->assertEquals($addPlayer->getNumber(), $player->getNumber()->number());
        $this->assertEquals($addPlayer->getName(), $player->getName());
        $this->assertEquals($addPlayer->getRole(), $player->getRole()->role());
        $this->assertEquals($addPlayer->getScore(), $player->getScore()->score());
    }
}
