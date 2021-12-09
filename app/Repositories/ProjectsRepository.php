<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Project;

/**
 * Class ProjectsRepository
 * @package App\Repositories
 */
final class ProjectsRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Project::class;
    }
}
