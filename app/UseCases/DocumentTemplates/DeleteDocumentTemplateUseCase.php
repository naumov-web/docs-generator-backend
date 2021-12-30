<?php

namespace App\UseCases\DocumentTemplates;

use App\DTO\Input\DocumentTemplates\DeleteDocumentTemplateDTO;
use App\Repositories\DocumentTemplatesRepository;
use App\UseCases\BaseUseCase;

/**
 * Class DeleteDocumentTemplateUseCase
 * @package App\UseCases\DocumentTemplates
 */
final class DeleteDocumentTemplateUseCase extends BaseUseCase
{
    /**
     * Document templates repository instance
     * @var DocumentTemplatesRepository
     */
    private DocumentTemplatesRepository $repository;

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return DeleteDocumentTemplateDTO::class;
    }

    /**
     * DeleteDocumentTemplateUseCase constructor
     * @param DocumentTemplatesRepository $repository
     */
    public function __construct(DocumentTemplatesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->repository->delete($this->input_dto->getDocumentTemplate());
    }
}
