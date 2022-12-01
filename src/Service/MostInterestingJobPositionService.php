<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\JobPosition;
use App\Repository\JobPositionRepository;

class MostInterestingJobPositionService
{
    private const MIN_PERCENTAGE_SKILLS_TO_MATCH = 20;

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
     * @param string $seniorityLevel
     * @param string[] $skills
     *
     * @return JobPosition|null
     */
    public function find(string $seniorityLevel, array $skills): ?JobPosition
    {
        $jobPositions = $this->jobPositionRepository->findBySeniorityLevel($seniorityLevel);

        $cleanedSkills = $this->cleanSkills($skills);

        return $this->findMostInterestingBySkills($jobPositions, $cleanedSkills);
    }

    /**
     * @param string[] $skills
     * @return string[]
     */
    private function cleanSkills(array $skills): array
    {
        $cleanedSkills = array_map(function ($item) {
            return trim(strtolower($item));
        }, $skills);

        return array_unique($cleanedSkills);
    }

    /**
     * @param JobPosition[] $jobPositions
     * @param string[] $skills
     *
     * @return JobPosition|null
     */
    private function findMostInterestingBySkills(array $jobPositions, array $skills): ?JobPosition
    {
        $maxPercentage = 0;
        $mostInterestingPosition = null;

        foreach ($jobPositions as $jobPosition) {
            $currentMatchPercentage = $this->getSkillsMatchPercentage($jobPosition, $skills);

            if ($currentMatchPercentage > $maxPercentage) {
                $maxPercentage = $currentMatchPercentage;
                $mostInterestingPosition = $jobPosition;
            }
        }

        return $maxPercentage >= self::MIN_PERCENTAGE_SKILLS_TO_MATCH ? $mostInterestingPosition : null;
    }

    /**
     * @param JobPosition $jobPosition
     * @param string[] $skills
     *
     * @return float
     */
    private function getSkillsMatchPercentage(JobPosition $jobPosition, array $skills): float
    {
        $jobPositionSkills = $this->cleanSkills($jobPosition->getRequiredSkills());
        
        $matchedSkills = array_intersect($skills, $jobPositionSkills);

        return (count($matchedSkills) / count($jobPositionSkills)) * 100;
    }
}