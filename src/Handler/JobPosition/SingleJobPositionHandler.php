<?php

declare(strict_types=1);

namespace App\Handler\JobPosition;

use App\Dto\JobPosition\JobPositionResponseDto;
use App\Entity\JobPosition;
use App\Repository\JobPositionRepository;
use App\Transformer\DtoResponse\JobPositionResponseDtoTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SingleJobPositionHandler
{
    /** @var JobPositionRepository */
    private $jobPositionRepository;

    /**
     * @param JobPositionRepository $jobPositionRepository
     */
    public function __construct(JobPositionRepository $jobPositionRepository)
    {
        $this->jobPositionRepository = $jobPositionRepository;
    }

    /**
     * @param int $id
     *
     * @return JobPositionResponseDto
     */
    public function handle(int $id): JobPositionResponseDto
    {
        $jobPosition = $this->jobPositionRepository->findOneById($id);

        if (!$jobPosition) {
            throw new NotFoundHttpException('Job position not found');
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