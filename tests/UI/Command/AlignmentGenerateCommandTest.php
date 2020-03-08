<?php

namespace App\Tests\UI\Command;

use App\Tests\BaseTestCase;
use Symfony\Component\Console\Exception\RuntimeException;

class AlignmentGenerateCommandTest extends BaseTestCase
{
    public function testNotTacticNameError()
    {
        $this->expectException(RuntimeException::class);
        $this->executeCommand('basket:alignment:generate');
    }

    public function testSampleAlignments(): void
    {
        $this->addTestPlayers();
        $commandTester = $this->executeCommand('basket:alignment:generate', ['tactic' => 'Defensa 1-3-1']);

        $this->assertEquals(0, $commandTester->getStatusCode());
    }
}
