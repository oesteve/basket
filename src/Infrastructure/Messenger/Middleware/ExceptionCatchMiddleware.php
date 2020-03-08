<?php

namespace App\Infrastructure\Messenger\Middleware;

use App\Application\Exception\ApplicationException;
use App\Application\Exception\ValidationException;
use App\Application\Exception\ValidationFieldException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ExceptionCatchMiddleware implements MiddlewareInterface
{
    /**
     * Only allow Application Exception behind CommandBus.
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (ValidationFailedException $validationFailedException) {
            $validationException = new ValidationException($validationFailedException->getMessage());

            /** @var ConstraintViolationInterface $violation */
            foreach ($validationFailedException->getViolations() as $violation) {
                $validationException->addFieldException(ValidationFieldException::create(
                    $violation->getPropertyPath(),
                    (string) $violation->getMessage()
                ));
            }

            throw $validationException;
        } catch (HandlerFailedException $handlerFailedException) {
            if ($handlerFailedException->getPrevious() instanceof ApplicationException) {
                throw $handlerFailedException->getPrevious();
            }

            throw ApplicationException::fromException($handlerFailedException->getPrevious() ?: $handlerFailedException);
        } catch (\Throwable $exception) {
            throw  new ApplicationException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
