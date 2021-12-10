<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class App\Repositories
 * @package App\Repositories
 */
final class UsersRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return User::class;
    }
}
