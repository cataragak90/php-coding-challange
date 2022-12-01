<?php

declare(strict_types=1);

namespace App\DataSource;

class DataRow
{
    /** @var int|null */
    public $id;

    /** @var string|null */
    public $jobTitle;

    /** @var string|null */
    public $seniorityLevel;

    /** @var string|null */
    public $country;

    /** @var string|null */
    public $city;

    /** @var float|null */
    public $salary;

    /** @var string|null */
    public $salaryCurrency;

    /** @var string[]|null */
    public $requiredSkills;

    /** @var string|null */
    public $companySize;

    /** @var string|null */
    public $companyDomain;
}