<?php

namespace App\Tests\UI\Command;

use App\Application\Exception\ValidationException;
use App\Tests\BaseTestCase;

class AddPlayerCommandTest extends BaseTestCase
{
    public function testValidationError()
    {
        $this->expectException(ValidationException::class);
        $this->executeCommand('basket:player:add', [
            // pass arguments to the helper
            'number' => '88',
            'name' => 'ricky',
            'role' => 'portero',
            'score' => '81',
        ]);
    }

    public function testAddPlayer()
    {
        $commandTester = $this->executeCommand('basket:player:add', [
                // pass arguments to the helper
                'number' => '88',
                'name' => 'ricky',
                'role' => 'BASE',
                'score' => '82',
            ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Player #88 ricky was added successfully', $output);
    }
}
