<?php

namespace App\Repositories;

use App\Models\Role;

/**
 * Class RolesRepository
 * @package App\Repositories
 */
final class RolesRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Role::class;
    }
}
