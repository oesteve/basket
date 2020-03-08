<?php

namespace App\Tests;

use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\PlayerNumber;
use App\Domain\Model\Player\PlayerRepository;
use App\Domain\Model\Player\PlayerRole;
use App\Domain\Model\Player\PlayerScore;
use App\Utils\SampleData;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class BaseTestCase extends WebTestCase
{
    /** @var KernelBrowser */
    protected $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function executeCommand(string $commandName, array $args = []): CommandTester
    {
        $application = new Application(static::$kernel);

        $command = $application->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($args);

        return $commandTester;
    }

    protected function addTestPlayers(): void
    {
        /** @var PlayerRepository $playerRepository */
        $playerRepository = $this->get(PlayerRepository::class);

        foreach (SampleData::playersData() as $playerData) {
            $number = new PlayerNumber($playerData[0]);
            $name = $playerData[1];
            $role = new PlayerRole($playerData[2]);
            $score = new PlayerScore($playerData[3]);

            $player = new Player($number, $name, $role, $score);

            $playerRepository->save($player);
        }
    }

    protected static function players(): array
    {
        return [
            new Player(new PlayerNumber(3), 'Player A', PlayerRole::Base(), new PlayerScore(1)),
            new Player(new PlayerNumber(2), 'Player B', PlayerRole::Base(), new PlayerScore(2)),
            new Player(new PlayerNumber(1), 'Player C', PlayerRole::Escolta(), new PlayerScore(3)),
            new Player(new PlayerNumber(4), 'Player D', PlayerRole::Escolta(), new PlayerScore(4)),
            new Player(new PlayerNumber(5), 'Player E', PlayerRole::Pivot(), new PlayerScore(100)),
            new Player(new PlayerNumber(6), 'Player E', PlayerRole::AlaPivot(), new PlayerScore(100)),
        ];
    }

    /**
     * @return object|null
     */
    public function get(string $id)
    {
        return static::$container->get($id);
    }
}
