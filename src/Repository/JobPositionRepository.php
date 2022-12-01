<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\JobPosition\JobPositionFilterRequestDto;
use App\Entity\JobPosition;
use App\Transformer\Entity\JobPositionTransformer;

class JobPositionRepository extends AbstractRepository
{
    /**
     * @param int $id
     *
     * @return JobPosition|null
     */
    public function findOneById(int $id): ?JobPosition
    {
       foreach ($this->getDataIterator() as $dataRow) {
           if ($dataRow->id === $id) {
               return JobPositionTransformer::transform($dataRow);
           }
       }

       return null;
    }

    /**
     * @param JobPositionFilterRequestDto $dto
     *
     * @return JobPosition[]
     */
    public function getFiltered(JobPositionFilterRequestDto $dto): array
    {
        $response = [];

        foreach ($this->getDataIterator() as $item) {
            $allowed = true;
            if ($dto->country) {
                $allowed = $allowed && $dto->country === $item->country;
            }

            if ($dto->city) {
                $allowed = $allowed && $dto->city === $item->city;
            }

            if ($allowed) {
                $response[] = JobPositionTransformer::transform($item);
            }
        }

        return $response;
    }

    /**
     * @param string $seniorityLevel
     *
     * @return JobPosition[]
     */
    public function findBySeniorityLevel(string $seniorityLevel): array
    {
        $response = [];

        foreach ($this->getDataIterator() as $dataRow) {
            if (strtolower($dataRow->seniorityLevel) === strtolower($seniorityLevel)) {
                $response[] = JobPositionTransformer::transform($dataRow);
            }
        }

        return $response;
    }
}