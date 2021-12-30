<?php

namespace Tests\Traits;

use App\DTO\Common\FileDTO;
use App\DTO\Input\DocumentTemplates\CreateDocumentTemplateDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\DocumentTemplate;
use App\Models\User;
use App\UseCases\DocumentTemplates\CreateDocumentTemplateUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

/**
 * Trait UseDocumentTemplates
 * @package Tests\Traits
 */
trait UseDocumentTemplates
{
    /**
     * Create document templates for testing
     *
     * @param User $owner
     * @return Collection
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     * @throws InvalidInputDTOException
     */
    protected function createDocumentTemplatesForTesting(User $owner): Collection
    {
        $result = collect([]);
        /**
         * @var CreateDocumentTemplateUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::CREATE_DOCUMENT_TEMPLATE);

        foreach ($this->document_templates as $document_template) {
            $data = array_merge(
                $document_template,
                [
                    'file' => [
                        'name' => 'template-1.docx',
                        'mime' => 'application/octet-stream',
                        'content' => base64_encode(file_get_contents(base_path('tests/resources/template-1.docx')))
                    ]
                ]
            );

            $use_case->setInputDTO(
                new CreateDocumentTemplateDTO(
                    $data['name'],
                    new FileDTO(
                        $data['file']['name'],
                        $data['file']['mime'],
                        $data['file']['content']
                    ),
                    $owner
                )
            );
            $use_case->execute();

            $result = $result->push($use_case->getDocumentTemplate());
        }

        return $result;
    }

    /**
     * Remove files from storage for each template (collect garbage files after test)
     *
     * @param Collection $document_templates
     * @return void
     */
    protected function removeFilesForTemplates(Collection $document_templates): void
    {
        foreach ($document_templates as $document_template) {
            /**
             * @var DocumentTemplate $document_template
             */
            $file = $document_template->file;

            @unlink($file->full_path);
        }
    }
}
