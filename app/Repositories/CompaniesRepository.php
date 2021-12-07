<?php

namespace App\Repositories;

use App\Models\Company;

/**
 * Class CompaniesRepository
 * @package App\Repositories
 */
final class CompaniesRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Company::class;
    }
}
