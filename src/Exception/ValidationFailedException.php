<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedException extends RuntimeException
{
    /** @var ConstraintViolationListInterface */
    private $constraintViolationList;

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @param string $message
     */
    public function __construct(
        ConstraintViolationListInterface $constraintViolationList,
        string $message = 'Payload validation error.'
    )
    {
        parent::__construct($message);

        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}