<?php

declare(strict_types=1);

namespace App\EventSubscriber\Exception;

use App\Response\Error\AbstractErrorResponse;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

abstract class AbstractExceptionSubscriber implements EventSubscriberInterface
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var string */
    private $env;

    /**
     * @param SerializerInterface $serializer
     * @param string $env
     */
    public function __construct(SerializerInterface $serializer, string $env)
    {
        $this->serializer = $serializer;
        $this->env = $env;
    }

    /**
     * @param ExceptionEvent $event
     */
    abstract public function treatException(ExceptionEvent $event): void;

    /**
     * @return int
     */
    abstract protected static function getPriority(): int;

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['treatException', static::getPriority()],
            ],
        ];
    }

    /**
     * @param AbstractErrorResponse $errorResponse
     *
     * @return string
     */
    protected function serializeErrorResponse(AbstractErrorResponse $errorResponse): string
    {
        $context = new SerializationContext();
        $context->setGroups($this->env);

        return $this->serializer->serialize($errorResponse, 'json', $context);
    }
}