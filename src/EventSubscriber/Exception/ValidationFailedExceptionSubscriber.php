<?php

declare(strict_types=1);

namespace App\EventSubscriber\Exception;

use App\Exception\ValidationFailedException;
use App\Response\Error\ValidationErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidationFailedExceptionSubscriber extends AbstractExceptionSubscriber
{
    private const PRIORITY = 10;

    /**
     * {@inheritDoc}
     */
    public static function getPriority(): int
    {
        return self::PRIORITY;
    }

    /**
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function treatException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ValidationFailedException) {
            return;
        }

        $event->setResponse(
            $this->createResponse($exception)
        );
    }

    /**
     * @param ValidationFailedException $exception
     *
     * @return Response
     */
    private function createResponse(ValidationFailedException $exception): Response
    {
        $errorResponse = new ValidationErrorResponse($exception->getConstraintViolationList());

        return new Response($this->serializeErrorResponse($errorResponse), Response::HTTP_BAD_REQUEST);
    }
}