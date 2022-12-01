<?php

declare(strict_types=1);

namespace App\EventSubscriber\Exception;

use App\Response\Error\HttpNotFoundErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpNotFoundExceptionSubscriber extends AbstractExceptionSubscriber
{
    private const PRIORITY = 11;

    /**
     * {@inheritDoc}
     */
    protected static function getPriority(): int
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

        if (!$exception instanceof NotFoundHttpException) {
            return;
        }

        $event->setResponse(
            $this->createResponse($exception)
        );
    }

    /**
     * @param NotFoundHttpException $exception
     *
     * @return Response
     */
    private function createResponse(NotFoundHttpException $exception): Response
    {
        $errorResponse = new HttpNotFoundErrorResponse(
            $exception->getMessage(),
            $exception->getTraceAsString()
        );

        return new Response($this->serializeErrorResponse($errorResponse), Response::HTTP_NOT_FOUND);
    }
}