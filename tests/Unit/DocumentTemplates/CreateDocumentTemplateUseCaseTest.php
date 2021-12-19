<?php

namespace Tests\Unit\DocumentTemplates;

use App\DTO\Common\FileDTO;
use App\DTO\Input\DocumentTemplates\CreateDocumentTemplateDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\DocumentTemplate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\BaseUseCaseTest;

/**
 * Class CreateDocumentTemplateUseCaseTest
 * @package Tests\Unit\DocumentTemplates
 */
final class CreateDocumentTemplateUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test creation of document template for simple user
     * Test case reproduce:
     * 1. Seed database
     * 2. Register simple user without company
     * 3. Define document template data
     * 4. Create use case and execute it
     * 5. Check that document template was created
     *
     * Expected: document template was created for current user
     *
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testCreationOfDocumentTemplateForSimpleUser(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user without company
        $user = $this->createUser();

        // 3. Define document template data
        $document_template_data = [
            'name' => 'Template one',
            'file' => [
                'name' => 'template-1.docx',
                'mime' => 'application/octet-stream',
                'content' => base64_encode(file_get_contents(base_path('tests/resources/template-1.docx')))
            ]
        ];

        // 4. Create use case and execute it
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::CREATE_DOCUMENT_TEMPLATE);
        $use_case->setInputDTO(
            new CreateDocumentTemplateDTO(
                $document_template_data['name'],
                new FileDTO(
                    $document_template_data['file']['name'],
                    $document_template_data['file']['mime'],
                    $document_template_data['file']['content']
                ),
                $user
            )
        );
        $use_case->execute();

        // 5. Check that document template was created
        $this->assertDatabaseHas(
            (new DocumentTemplate())->getTable(),
            [
                'name' => $document_template_data['name'],
                'owner_id' => $user->id,
                'owner_type' => get_class($user),
            ]
        );

        /**
         * @var DocumentTemplate $document_template
         */
        $document_template = DocumentTemplate::query()->where('name', $document_template_data['name'])->first();

        $this->assertNotNull($document_template->file);

        $this->assertTrue(file_exists($document_template->file->full_path));

        unlink($document_template->file->full_path);

        $this->assertFalse(file_exists($document_template->file->full_path));
    }

    /**
     * Test creation of document template for company owner
     * Test case reproduce:
     * 1. Seed database
     * 2. Register user with company
     * 3. Define document template data
     * 4. Create use case and execute it
     * 5. Check that document template was created
     *
     * Expected: document template was created for first company of current user
     *
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testCreationOfDocumentTemplateForCompanyOwner(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user without company
        $user = $this->createUser($index = 1);

        // 3. Define document template data
        $document_template_data = [
            'name' => 'Template one for company',
            'file' => [
                'name' => 'template-1.docx',
                'mime' => 'application/octet-stream',
                'content' => base64_encode(file_get_contents(base_path('tests/resources/template-1.docx')))
            ]
        ];

        // 4. Create use case and execute it
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::CREATE_DOCUMENT_TEMPLATE);
        $use_case->setInputDTO(
            new CreateDocumentTemplateDTO(
                $document_template_data['name'],
                new FileDTO(
                    $document_template_data['file']['name'],
                    $document_template_data['file']['mime'],
                    $document_template_data['file']['content']
                ),
                $user
            )
        );
        $use_case->execute();

        // 5. Check that document template was created
        $this->assertDatabaseHas(
            (new DocumentTemplate())->getTable(),
            [
                'name' => $document_template_data['name'],
                'owner_id' => $user->first_company->id,
                'owner_type' => get_class($user->first_company),
            ]
        );

        /**
         * @var DocumentTemplate $document_template
         */
        $document_template = DocumentTemplate::query()->where('name', $document_template_data['name'])->first();

        $this->assertNotNull($document_template->file);

        $this->assertTrue(file_exists($document_template->file->full_path));

        unlink($document_template->file->full_path);

        $this->assertFalse(file_exists($document_template->file->full_path));
    }
}
