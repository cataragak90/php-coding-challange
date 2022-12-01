<?php

declare(strict_types=1);

namespace App\Entity;

class JobPosition
{
    /** @var int */
    private $id;

    /** @var string */
    private $jobTitle;

    /** @var string */
    private $seniorityLevel;

    /** @var string[] */
    private $requiredSkills;

    /** @var Location */
    private $location;

    /** @var Salary */
    private $salary;

    /** @var Company */
    private $company;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    /**
     * @param string $jobTitle
     *
     * @return JobPosition
     */
    public function setJobTitle(string $jobTitle): JobPosition
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeniorityLevel(): string
    {
        return $this->seniorityLevel;
    }

    /**
     * @param string $seniorityLevel
     *
     * @return JobPosition
     */
    public function setSeniorityLevel(string $seniorityLevel): JobPosition
    {
        $this->seniorityLevel = $seniorityLevel;

        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     *
     * @return JobPosition
     */
    public function setLocation(Location $location): JobPosition
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Salary
     */
    public function getSalary(): Salary
    {
        return $this->salary;
    }

    /**
     * @param Salary $salary
     *
     * @return JobPosition
     */
    public function setSalary(Salary $salary): JobPosition
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return JobPosition
     */
    public function setCompany(Company $company): JobPosition
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @param string[] $requiredSkills
     *
     * @return $this
     */
    public function setRequiredSkills(array $requiredSkills): JobPosition
    {
        $this->requiredSkills = $requiredSkills;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRequiredSkills(): array
    {
        return $this->requiredSkills;
    }
}