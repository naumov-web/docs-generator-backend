<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UsersService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseApiController
 * @package App\Http\Controllers\Api
 */
abstract class BaseApiController extends Controller
{
    /**
     * Get current user instance
     *
     * @return User
     * @throws BindingResolutionException
     */
    protected function getCurrentUser(): User
    {
        $username = get_remote_user_name();
        /**
         * @var UsersService $service
         */
        $service = UsersService::getInstance();

        return $service->getUserByUsername($username);
    }
}
