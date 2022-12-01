<?php

declare(strict_types=1);

namespace App\Transformer\Entity;

use App\DataSource\DataRow;
use App\Entity\JobPosition;

class JobPositionTransformer
{
    /**
     * @param DataRow $dataRow
     *
     * @return JobPosition
     */
    public static function transform(DataRow $dataRow): JobPosition
    {
        $jobPosition = new JobPosition($dataRow->id);

        $jobPosition->setJobTitle($dataRow->jobTitle)
            ->setSeniorityLevel($dataRow->seniorityLevel)
            ->setRequiredSkills($dataRow->requiredSkills)
            ->setLocation(LocationTransformer::transform($dataRow))
            ->setSalary(SalaryTransformer::transform($dataRow))
            ->setCompany(CompanyTransformer::transform($dataRow));

        return $jobPosition;
    }
}