<?php

declare(strict_types=1);

namespace App\Dto\JobPosition;

use App\Dto\Company\CompanyResponseDto;
use App\Dto\Location\LocationResponseDto;
use JMS\Serializer\Annotation as JMS;

class JobPositionResponseDto
{
    /**
     * @JMS\Type("int")
     *
     * @var string
     */
    public $id;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $jobTitle;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $seniorityLevel;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $salary;

    /**
     * @JMS\Type("array<string>")
     *
     * @var string[]
     */
    public $requiredSkills;

    /**
     * @JMS\Type("App\Dto\Location\LocationResponseDto")
     *
     * @var LocationResponseDto
     */
    public $location;

    /**
     * @JMS\Type("App\Dto\Company\CompanyResponseDto")
     *
     * @var CompanyResponseDto
     */
    public $company;
}