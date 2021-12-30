<?php

namespace Tests\Unit\DocumentTemplates;

use App\DTO\Input\DocumentTemplates\DeleteDocumentTemplateDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\DocumentTemplate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Traits\UseDocumentTemplates;
use Tests\Unit\BaseUseCaseTest;

/**
 * Class DeleteDocumentTemplateUseCaseTest
 * @package Tests\Unit\DocumentTemplates
 */
final class DeleteDocumentTemplateUseCaseTest extends BaseUseCaseTest
{
    use UseDocumentTemplates;

    /**
     * Document templates data for testing
     * @var array
     */
    private array $document_templates = [
        [
            'name' => 'First template'
        ]
    ];

    /**
     * Test deleting of document template without custom conditions
     * Test case reproduce:
     * 1. Seed database
     * 2. Register simple user
     * 3. Create document templates for testing
     * 4. Create use case and try to delete document template
     *
     * Expected: Document template was marked as soft deleted
     *
     * @test
     * @return void
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testSuccessDelete(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user
        $user = $this->createUser();

        // 3. Create document templates for testing
        $document_templates = $this->createDocumentTemplatesForTesting($user);
        /**
         * @var DocumentTemplate $document_template
         */
        $document_template = $document_templates->first();

        // 4. Create use case and try to delete document template
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::DELETE_DOCUMENT_TEMPLATE);
        $use_case->setInputDTO(new DeleteDocumentTemplateDTO($document_template));
        $use_case->execute();

        $this->assertSoftDeleted(
            (new DocumentTemplate())->getTable(),
            [
                'id' => $document_template->id
            ]
        );

        $this->removeFilesForTemplates($document_templates);
    }
}
