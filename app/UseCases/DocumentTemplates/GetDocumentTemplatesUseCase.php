<?php

namespace App\UseCases\DocumentTemplates;

use App\DTO\Input\DocumentTemplates\GetDocumentTemplatesDTO;
use App\UseCases\BaseUseCase;

/**
 * Class GetDocumentTemplatesUseCase
 * @package App\UseCases\DocumentTemplates
 */
final class GetDocumentTemplatesUseCase extends BaseUseCase
{

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return GetDocumentTemplatesDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        // TODO: Implement execute() method.
    }
}
