<?php

namespace App\Repositories;

use App\Models\DocumentTemplate;

/**
 * Class DocumentTemplatesRepository
 * @package App\Repositories
 */
final class DocumentTemplatesRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return DocumentTemplate::class;
    }
}
