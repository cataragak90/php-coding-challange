<?php

declare(strict_types=1);

namespace App\Handler\JobPosition;

use App\Dto\JobPosition\JobPositionMostInterestingRequestDto;
use App\Dto\JobPosition\JobPositionResponseDto;
use App\Entity\JobPosition;
use App\Service\MostInterestingJobPositionService;
use App\Service\ValidatorService;
use App\Transformer\DtoResponse\JobPositionResponseDtoTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MostInterestingJobPositionHandler
{
    /** @var ValidatorService */
    private $validator;

    /** @var MostInterestingJobPositionService */
    private $mostInterestingJobPositionService;

    /**
     * @param ValidatorService $validatorService
     * @param MostInterestingJobPositionService $mostInterestingJobPositionService
     */
    public function __construct(
        ValidatorService $validatorService,
        MostInterestingJobPositionService $mostInterestingJobPositionService
    ) {
        $this->validator = $validatorService;
        $this->mostInterestingJobPositionService = $mostInterestingJobPositionService;
    }

    /**
     * @param JobPositionMostInterestingRequestDto $dto
     *
     * @return JobPositionResponseDto
     */
    public function handle(JobPositionMostInterestingRequestDto $dto): JobPositionResponseDto
    {
        $this->validator->validate($dto);

        $jobPosition = $this->mostInterestingJobPositionService->find(
            $dto->seniorityLevel,
            $dto->skills
        );

        if (!$jobPosition) {
            throw new NotFoundHttpException('No job position found for this candidate');
        }

        return $this->createResponse($jobPosition);
    }

    /**
     * @param JobPosition $jobPosition
     *
     * @return JobPositionResponseDto
     */
    private function createResponse(JobPosition $jobPosition): JobPositionResponseDto
    {
        return JobPositionResponseDtoTransformer::transform($jobPosition);
    }
}