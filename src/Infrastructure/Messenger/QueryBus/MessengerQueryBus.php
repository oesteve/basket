<?php

namespace App\Infrastructure\Messenger\QueryBus;

use App\Application\Query\Query;
use App\Application\Query\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageQueryBus)
    {
        $this->messageBus = $messageQueryBus;
    }

    /**
     * @return mixed The handler returned value
     */
    public function query(Query $query)
    {
        return $this->handle($query);
    }
}
