<?php

declare(strict_types=1);

namespace App\Tests\EventSubscriber\Exception;

use JMS\Serializer\SerializerInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

abstract class AbstractExceptionSubscriberTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected const ENV = 'test';

    /** @var SerializerInterface|MockInterface */
    protected $serializer;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = Mockery::mock(SerializerInterface::class);
    }

    /**
     * @param Throwable $throwable
     *
     * @return ExceptionEvent|MockInterface
     */
    protected function mockEvent(Throwable $throwable): ExceptionEvent
    {
        $event = Mockery::mock(ExceptionEvent::class);

        $event->shouldReceive('getThrowable')
            ->andReturn($throwable)
            ->once();

        return $event;
    }
}
