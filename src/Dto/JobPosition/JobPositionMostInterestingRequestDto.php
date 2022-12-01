<?php

declare(strict_types=1);

namespace App\Dto\JobPosition;

use Symfony\Component\Validator\Constraints as Assert;

class JobPositionMostInterestingRequestDto
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->skills = $parameters['skills'] ?? null;
        $this->seniorityLevel = $parameters['seniority_level'] ?? null;
    }

    /**
     * @Assert\Type("array", message="Value should be an array.")
     * @Assert\NotBlank(message="This field cannot be blank")
     *
     * @var string|null
     */
    public $skills;

    /**
     * @Assert\Type("string", message="Value should be a string.")
     * @Assert\NotBlank(message="This field cannot be blank")
     *
     * @var string|null
     */
    public $seniorityLevel;

}