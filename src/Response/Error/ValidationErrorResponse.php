<?php

declare(strict_types=1);

namespace App\Response\Error;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorResponse extends AbstractErrorResponse
{
    private const PAYLOAD_VALIDATION_ERROR_CODE = 1000;

    /**
     * @JMS\Groups(groups={"prod", "test", "dev"})
     *
     * @var ConstraintViolationListInterface
     */
    private $errors;

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct(self::PAYLOAD_VALIDATION_ERROR_CODE);

        $this->errors = $constraintViolationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}