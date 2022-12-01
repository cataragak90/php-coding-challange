<?php

declare(strict_types=1);

namespace App\Tests\EventSubscriber\Exception;

use App\EventSubscriber\Exception\ValidationFailedExceptionSubscriber;
use App\Exception\ValidationFailedException;
use App\Response\Error\ValidationErrorResponse;
use JMS\Serializer\SerializerInterface;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedExceptionSubscriberTest extends AbstractExceptionSubscriberTest
{
    /** @var ValidationFailedExceptionSubscriber */
    private $exceptionSubscriber;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = Mockery::mock(SerializerInterface::class);
        $this->exceptionSubscriber = new ValidationFailedExceptionSubscriber($this->serializer, self::ENV);
    }

    /**
     * @return void
     */
    public function testTreatExceptionShouldIgnoreException(): void
    {
        $event = $this->mockEvent(new NotFoundHttpException('resource not found'));
        $event->shouldNotReceive('setResponse');

        $this->exceptionSubscriber->treatException($event);
    }

    /**
     * @return void
     */
    public function testTreatExceptionShouldProcessException(): void
    {
        $violationsList = Mockery::mock(ConstraintViolationListInterface::class);

        $this->serializer->shouldReceive('serialize')
            ->with(
                Mockery::on(function (ValidationErrorResponse $errorResponse) use ($violationsList) {
                    return $errorResponse->getCode() === 1000 && $errorResponse->getErrors() === $violationsList;
                }),
                Mockery::any(),
                Mockery::any()
            )
            ->andReturn('')
            ->once();

        $event = $this->mockEvent(new ValidationFailedException($violationsList));
        $event->shouldReceive('setResponse')
            ->with(Mockery::on(function (Response $response) {
                return $response->getStatusCode() === Response::HTTP_BAD_REQUEST;
            }))
            ->once();

        $this->exceptionSubscriber->treatException($event);
    }
}
