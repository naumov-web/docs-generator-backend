<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Input\User\ShowDetailUserDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Users\UserDetailResource;
use App\Models\User;
use App\UseCases\UseCaseFactory;
use App\UseCases\Users\ShowDetailUserUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\V1
 */
final class UserController extends BaseApiController
{
    /**
     * Use case factory instance
     * @var UseCaseFactory
     */
    private UseCaseFactory $use_case_factory;

    /**
     * AuthController constructor
     * @param UseCaseFactory $use_case_factory
     */
    public function __construct(UseCaseFactory $use_case_factory)
    {
        $this->use_case_factory = $use_case_factory;
    }

    /**
     * Show current user detail info
     *
     * @return UserDetailResource
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function show(): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = auth()->user();
        /**
         * @var ShowDetailUserUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::SHOW_DETAIL_USER);
        $use_case->setInputDTO(new ShowDetailUserDTO($user));
        $use_case->execute();

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.user_info_loaded_successfully'),
                'user' => new UserDetailResource($use_case->getUser())
            ]
        );
    }
}
