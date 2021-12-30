<?php

declare(strict_types=1);

namespace App\UseCases\DocumentTemplates;

use App\DTO\Input\DocumentTemplates\CreateDocumentTemplateDTO;
use App\Models\DocumentTemplate;
use App\Models\User;
use App\Repositories\DocumentTemplatesRepository;
use App\Services\FilesService;
use App\UseCases\BaseUseCase;

/**
 * Class CreateDocumentTemplateUseCase
 * @package App\UseCases\DocumentTemplates
 */
final class CreateDocumentTemplateUseCase extends BaseUseCase
{
    /**
     * Document templates repository instance
     * @var DocumentTemplatesRepository
     */
    private DocumentTemplatesRepository $document_templates_repository;

    /**
     * Files service instance
     * @var FilesService
     */
    private FilesService $files_service;

    /**
     * Document template instance
     * @var DocumentTemplate
     */
    private DocumentTemplate $document_template;

    /**
     * CreateDocumentTemplateUseCase constructor
     * @param DocumentTemplatesRepository $document_templates_repository
     * @param FilesService $files_service
     */
    public function __construct(DocumentTemplatesRepository $document_templates_repository, FilesService $files_service)
    {
        $this->document_templates_repository = $document_templates_repository;
        $this->files_service = $files_service;
    }

    /**
     * Get created document template instance
     *
     * @return DocumentTemplate
     */
    public function getDocumentTemplate(): DocumentTemplate
    {
        return $this->document_template;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateDocumentTemplateDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        // 1. Define owner instance
        /**
         * @var User $user
         */
        $user = $this->input_dto->getUser();
        $owner = $user->first_company ?? $user;

        // 2. Create document template instance
        /**
         * @var DocumentTemplate $document_template
         */
        $document_template = $this->document_templates_repository->store([
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
            'name' => $this->input_dto->getName()
        ]);

        // 3. Create file instance for document template
        $this->files_service->create($document_template, $this->input_dto->getFile());

        $this->document_template = $document_template;
    }
}
