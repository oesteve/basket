<?php

namespace App\Infrastructure\Messenger\CommandBus;

use App\Application\Command\Command;
use App\Application\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBus
{
    /** @var MessageBusInterface */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(Command $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
