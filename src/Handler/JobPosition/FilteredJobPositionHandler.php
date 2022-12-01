<?php

declare(strict_types=1);

namespace App\Handler\JobPosition;

use App\Dto\JobPosition\JobPositionFilterRequestDto;
use App\Dto\JobPosition\JobPositionResponseDto;
use App\Entity\JobPosition;
use App\Repository\JobPositionRepository;
use App\Service\ValidatorService;
use App\Transformer\DtoResponse\JobPositionResponseDtoTransformer;

class FilteredJobPositionHandler
{
    /** @var JobPositionRepository */
    private $jobPositionRepository;

    /** @var ValidatorService */
    private $validator;

    /**
     * @param JobPositionRepository $jobPositionRepository
     * @param ValidatorService $validatorService
     */
    public function __construct(
        JobPositionRepository $jobPositionRepository,
        ValidatorService $validatorService
    ) {
        $this->jobPositionRepository = $jobPositionRepository;
        $this->validator = $validatorService;
    }

    /**
     * @param JobPositionFilterRequestDto $dto
     *
     * @return JobPositionResponseDto[]
     */
    public function handle(JobPositionFilterRequestDto $dto): array
    {
        $this->validator->validate($dto);

        $jobPositions = $this->orderByJobPositions(
            $this->jobPositionRepository->getFiltered($dto),
            $dto->orderBy
        );

        return $this->createResponse($jobPositions);
    }

    /**
     * @param array $jobPositions
     * @param string|null $field
     *
     * @return JobPosition[]
     */
    private function orderByJobPositions(array $jobPositions, ?string $field): array
    {
        if (!$field) {
            return $jobPositions;
        }

        usort($jobPositions, function (JobPosition $itemOne, JobPosition $itemTwo) use ($field) {
            $valueOne = $this->getFieldValueForOrdering($itemOne, $field);
            $valueTwo = $this->getFieldValueForOrdering($itemTwo, $field);

            if ($valueOne === $valueTwo) {
                return 0;
            }

            return $valueOne < $valueTwo ? -1 : 1;
        });

        return $jobPositions;
    }

    /**
     * @param JobPosition $jobPosition
     * @param string $field
     *
     * @return float|int|string
     */
    private function getFieldValueForOrdering(JobPosition $jobPosition, string $field)
    {
        if ($field === JobPositionFilterRequestDto::ORDER_BY_SALARY_FIELD) {
            return $jobPosition->getSalary()->getValue();
        }

        if ($field === JobPositionFilterRequestDto::ORDER_BY_SENIORITY_LEVEL_FIELD) {
            return $jobPosition->getSeniorityLevel();
        }

        return 0;
    }

    /**
     * @param JobPosition[] $jobPositions
     *
     * @return JobPositionResponseDto[]
     */
    private function createResponse(array $jobPositions): array
    {
        return array_map(function (JobPosition $jobPosition) {
            return JobPositionResponseDtoTransformer::transform($jobPosition);
        }, $jobPositions);
    }
}