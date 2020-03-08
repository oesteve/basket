<?php

namespace App\Tests\UI\Command;

use App\Application\Exception\ValidationException;
use App\Domain\EventDispatcher;
use App\Tests\BaseTestCase;
use App\Tests\Infrastructure\InMemory\EventStore\TestEvent;

class ListEventsCommandTest extends BaseTestCase
{
    public function testValidationError(): void
    {
        $this->expectException(ValidationException::class);
        $this->executeCommand('basket:events:list', [
            // pass arguments to the helper
            'position' => '-1',
        ]);
    }

    public function testEmptyStore(): void
    {
        $commandTester = $this->executeCommand('basket:events:list');

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('No events found in the event store', $output);
    }

    public function testListStoredEvents(): void
    {
        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->get(EventDispatcher::class);
        $eventDispatcher->dispatch(new TestEvent(new \DateTime('2020-03-08T12:48:48+00:00')));

        $commandTester = $this->executeCommand('basket:events:list');

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('2020-03-08 12:48:48   App\Tests\Infrastructure\InMemory\EventStore\TestEvent', $output);
    }
}
