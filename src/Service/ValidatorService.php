<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidationFailedException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $object
     * @param mixed $groups
     * @param Constraint|Constraint[]|null $constraints
     *
     * @throws ValidationFailedException
     *
     * @return void
     */
    public function validate(object $object, $groups = null, $constraints = null): void
    {
        $errors = $this->validator->validate($object, $constraints, $groups);

        if (count($errors) > 0) {
            throw new ValidationFailedException($errors);
        }
    }
}