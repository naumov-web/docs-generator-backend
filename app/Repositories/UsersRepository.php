<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

/**
 * Class UsersRepository
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
