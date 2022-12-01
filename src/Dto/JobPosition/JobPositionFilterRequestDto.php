<?php

declare(strict_types=1);

namespace App\Dto\JobPosition;

use Symfony\Component\Validator\Constraints as Assert;

class JobPositionFilterRequestDto
{
    public const ORDER_BY_SENIORITY_LEVEL_FIELD = 'seniority_level';
    public const ORDER_BY_SALARY_FIELD = 'salary';
    public const ALLOWED_ORDER_BY_VALUES = [self::ORDER_BY_SENIORITY_LEVEL_FIELD, self::ORDER_BY_SALARY_FIELD];

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->country = $parameters['country'] ?? null;
        $this->city = $parameters['city'] ?? null;
        $this->orderBy = $parameters['order_by'] ?? null;
    }

    /**
     * @Assert\Type("string", message="Value should be a string")
     *
     * @var string|null
     */
    public $country;

    /**
     * @Assert\Type("string", message="Value should be a string")
     *
     * @var string|null
     */
    public $city;

    /**
     * @Assert\Type("string", message="Value should be a string")
     * @Assert\Choice(
     *     choices=JobPositionFilterRequestDto::ALLOWED_ORDER_BY_VALUES,
     *     message="The value is not valid, the allowed values are: {{ choices }}")
     *
     * @var string|null
     */
    public $orderBy;
}