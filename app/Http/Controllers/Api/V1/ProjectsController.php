<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Input\Projects\CreateProjectDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Projects\CreateProjectRequest;
use App\UseCases\Projects\CreateProjectUseCase;
use App\UseCases\UseCaseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ProjectsController
 * @package App\Http\Controllers\Api\V1;
 */
final class ProjectsController extends BaseApiController
{
    /**
     * Use case factory instance
     * @var UseCaseFactory
     */
    private UseCaseFactory $use_case_factory;

    /**
     * ProjectsController constructor
     * @param UseCaseFactory $use_case_factory
     */
    public function __construct(UseCaseFactory $use_case_factory)
    {
        $this->use_case_factory = $use_case_factory;
    }

    /**
     * Create new project
     *
     * @param CreateProjectRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     * @throws InvalidInputDTOException
     */
    public function create(CreateProjectRequest $request): JsonResponse
    {
        $user = $this->getCurrentUser();
        /**
         * @var CreateProjectUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::CREATE_PROJECT);
        $use_case
            ->setInputDTO(
                new CreateProjectDTO(
                    $user,
                    $request->system_name,
                    $request->name
                )
            )
            ->execute();

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.project_created_successfully')
            ],
            Response::HTTP_CREATED
        );
    }
}
