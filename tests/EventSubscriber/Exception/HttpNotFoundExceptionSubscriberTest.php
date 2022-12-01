<?php

declare(strict_types=1);

namespace App\Tests\EventSubscriber\Exception;

use App\EventSubscriber\Exception\HttpNotFoundExceptionSubscriber;
use App\Response\Error\HttpNotFoundErrorResponse;
use Exception;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpNotFoundExceptionSubscriberTest extends AbstractExceptionSubscriberTest
{
    /** @var HttpNotFoundExceptionSubscriber */
    private $exceptionSubscriber;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->exceptionSubscriber = new HttpNotFoundExceptionSubscriber($this->serializer, self::ENV);
    }

    /**
     * @return void
     */
    public function testTreatExceptionShouldIgnoreException(): void
    {
        $event = $this->mockEvent(new Exception('this is a test message'));
        $event->shouldNotReceive('setResponse');

        $this->exceptionSubscriber->treatException($event);
    }

    /**
     * @return void
     */
    public function testTreatExceptionShouldProcessException(): void
    {
        $this->serializer->shouldReceive('serialize')
            ->with(
                Mockery::on(function (HttpNotFoundErrorResponse $errorResponse) {
                    return $errorResponse->getCode() === 1001 && $errorResponse->getMessage() === 'resource not found';
                }),
                Mockery::any(),
                Mockery::any()
            )
            ->andReturn('')
            ->once();

        $event = $this->mockEvent(new NotFoundHttpException('resource not found'));
        $event->shouldReceive('setResponse')
            ->with(Mockery::on(function (Response $response) {
                return $response->getStatusCode() === Response::HTTP_NOT_FOUND;
            }))
            ->once();

        $this->exceptionSubscriber->treatException($event);
    }
}
