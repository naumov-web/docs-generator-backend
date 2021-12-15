<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Input\Auth\LoginDTO;
use App\DTO\Input\Auth\RegisterUserDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\RegisterUseCase;
use App\UseCases\UseCaseFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\V1;
 */
final class AuthController extends BaseApiController
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
     * Register user action
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     * @throws InvalidInputDTOException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /**
         * @var RegisterUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $use_case->setInputDTO(
            (new RegisterUserDTO())
                ->fill(
                    $request->only([
                        'email',
                        'password',
                        'company_name'
                    ])
                )
        );
        $use_case->execute();

        return response()->json([
            'success' => true,
            'message' => __('messages.user_registered_successfully')
        ]);
    }

    /**
     * Login user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws AuthorizationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        /**
         * @var LoginUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::LOGIN);
        $use_case->setInputDTO(
            (new LoginDTO())
                ->fill(
                    $request->only([
                        'email',
                        'password',
                    ])
                )
        );
        $use_case->execute();

        return response()->json([
            'success' => true,
            'message' => __('messages.user_logged_successfully'),
            'token' => $use_case->getToken()
        ]);
    }
}
