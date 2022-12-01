<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\JobPosition\JobPositionFilterRequestDto;
use App\Dto\JobPosition\JobPositionMostInterestingRequestDto;
use App\Dto\JobPosition\JobPositionResponseDto;
use App\Handler\JobPosition\FilteredJobPositionHandler;
use App\Handler\JobPosition\MostInterestingJobPositionHandler;
use App\Handler\JobPosition\SingleJobPositionHandler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;

/**
 * @Rest\Route(path="/job-positions")
 */
class JobPositionController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(name="job_position.get", path="/{id}", requirements={"id"="\d+"})
     *
     * @SWG\Tag(name="Job position")
     *
     * @SWG\Response(response=200, description="Success response", @Model(type=JobPositionResponseDto::class))
     * @SWG\Response(response=404, description="Not found.")
     *
     * @param SingleJobPositionHandler $handler
     * @param string $id
     *
     * @return View
     */
    public function getAction(SingleJobPositionHandler $handler, string $id): View
    {
        return $this->view($handler->handle((int)$id), Response::HTTP_OK);
    }

    /**
     * @Rest\Get(name="job_position.get_most_intresting", path="/most-intresting")
     *
     * @Rest\QueryParam(name="skills", nullable=true, map=true, description="Candidate's skills")
     * @Rest\QueryParam(name="seniority_level", nullable=true, description="Candidate's seniotity level")
     *
     * @SWG\Tag(name="Job position")
     *
     * @SWG\Response(response=200, description="Success response", @Model(type=JobPositionResponseDto::class))
     * @SWG\Response(response=404, description="Not found.")
     *
     * @param MostInterestingJobPositionHandler $handler
     * @param ParamFetcher $paramFetcher
     *
     * @return View
     */
    public function getTheMostInterestingAction(
        MostInterestingJobPositionHandler $handler,
        ParamFetcher $paramFetcher
    ): View {
        $dto = new JobPositionMostInterestingRequestDto($paramFetcher->all());

        return $this->view($handler->handle($dto), Response::HTTP_OK);
    }


    /**
     * @Rest\Get(name="job_position.get_by_location", path="")
     *
     * @Rest\QueryParam(name="country", nullable=true, description="Filter by country")
     * @Rest\QueryParam(name="city", nullable=true, description="Filter by city")
     * @Rest\QueryParam(name="order_by", nullable=true, description="Order by column (seniority_level or salary)")
     *
     * @SWG\Tag(name="Job position")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Success response",
     *     @SWG\Schema(type="array", @Model(type=JobPositionResponseDto::class))
     * )
     * @SWG\Response(response=404, description="Not found.")
     *
     * @param FilteredJobPositionHandler $handler
     * @param ParamFetcher $paramFetcher
     *
     * @return View
     */
    public function getFiltered(FilteredJobPositionHandler $handler, ParamFetcher $paramFetcher): View
    {
        $dto = new JobPositionFilterRequestDto($paramFetcher->all());

        return $this->view($handler->handle($dto), Response::HTTP_OK);
    }
}