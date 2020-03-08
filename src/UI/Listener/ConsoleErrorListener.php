<?php

namespace App\UI\Listener;

use App\Application\Exception\ValidationException;
use App\Application\Exception\ValidationFieldException;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsoleErrorListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [ConsoleEvents::ERROR => 'handle'];
    }

    public function handle(ConsoleErrorEvent $event): void
    {
        $exception = $event->getError();

        if ($exception instanceof ValidationException) {
            $input = $event->getInput();
            $output = $event->getOutput();

            $messages = array_map(function (ValidationFieldException $fieldException) {
                return sprintf('[%s] %s', $fieldException->getField(), $fieldException->getMessage());
            }, $exception->getFieldExceptions());

            $io = new SymfonyStyle($input, $output);
            $io->error('Validation errors:');
            $io->listing($messages);

            $event->setExitCode(1);
        }
    }
}
