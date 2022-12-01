<?php

declare(strict_types=1);

namespace App\Transformer\DtoResponse;

use App\Dto\Company\CompanyResponseDto;
use App\Dto\JobPosition\JobPositionResponseDto;
use App\Dto\Location\LocationResponseDto;
use App\Entity\JobPosition;

class JobPositionResponseDtoTransformer
{
    /**
     * @param JobPosition $jobPosition
     *
     * @return JobPositionResponseDto
     */
    public static function transform(JobPosition $jobPosition): JobPositionResponseDto
    {
        $location = $jobPosition->getLocation();
        $company = $jobPosition->getCompany();

        $response = new JobPositionResponseDto();
        $response->id = $jobPosition->getId();
        $response->jobTitle = $jobPosition->getJobTitle();
        $response->seniorityLevel = $jobPosition->getSeniorityLevel();
        $response->salary = $jobPosition->getSalary();
        $response->requiredSkills = $jobPosition->getRequiredSkills();
        $response->location = new LocationResponseDto($location->getCountry(), $location->getCity());
        $response->company = new CompanyResponseDto($company->getSize(), $company->getDomain());

        return $response;
    }
}