<?php

namespace App\Repositories;

use App\Models\File;

/**
 * Class FilesRepository
 * @package App\Repositories
 */
final class FilesRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return File::class;
    }
}
