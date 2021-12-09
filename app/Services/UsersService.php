<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Common\FilterDTO;
use App\Models\User;
use App\Repositories\UsersRepository;

/**
 * Class UsersService
 * @package App\Services
 */
final class UsersService extends BaseEntityService
{
    /**
     * Users repository instance
     * @var UsersRepository
     */
    protected UsersRepository $repository;

    /**
     * UsersService constructor
     * @param UsersRepository $repository
     */
    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get user instance by username
     *
     * @param string $username
     * @return User
     */
    public function getUserByUsername(string $username): User
    {
        /**
         * @var User $user
         */
        if (!$user = $this->repository->getFirstByFilters([new FilterDTO('username', '=', $username)])) {
            $user = $this->repository->store([
                'username' => $username
            ]);
        }

        return $user;
    }
}
