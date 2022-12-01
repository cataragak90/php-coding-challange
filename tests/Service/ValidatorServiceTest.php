<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Exception\ValidationFailedException;
use App\Service\ValidatorService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var ValidatorInterface|MockInterface */
    private $validator;

    /** @var ValidatorService */
    private $service;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = Mockery::mock(ValidatorInterface::class);
        $this->service = new ValidatorService($this->validator);
    }

    /**
     * @return void
     */
    public function testValidateSuccess(): void
    {
        $this->validator->shouldReceive('validate')
            ->andReturn($this->mockConstraint(0))
            ->once();

        $this->service->validate(Mockery::mock());
    }

    /**
     * @return void
     */
    public function testValidateValidationFails(): void
    {
        $this->expectException(ValidationFailedException::class);

        $this->validator->shouldReceive('validate')
            ->andReturn($this->mockConstraint(3))
            ->once();

        $this->service->validate(Mockery::mock());
    }

    /**
     * @param int $numberOfViolations
     *
     * @return ConstraintViolationListInterface|MockInterface
     */
    private function mockConstraint(int $numberOfViolations): ConstraintViolationListInterface
    {
        $constraint = Mockery::mock(ConstraintViolationListInterface::class);
        $constraint->shouldReceive('count')
            ->andReturn($numberOfViolations)
            ->once();

        return $constraint;
    }
}
