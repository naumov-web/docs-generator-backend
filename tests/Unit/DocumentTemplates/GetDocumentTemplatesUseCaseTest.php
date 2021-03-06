<?php

namespace Tests\Unit\DocumentTemplates;

use App\DTO\Input\DocumentTemplates\GetDocumentTemplatesDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\UseCases\BaseUseCase;
use App\UseCases\Contracts\IGettingEntities;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Traits\UseDocumentTemplates;
use Tests\Unit\BaseUseCaseTest;

/**
 * Class GetDocumentTemplatesUseCaseTest
 * @package Tests\Unit\DocumentTemplates
 */
final class GetDocumentTemplatesUseCaseTest extends BaseUseCaseTest
{
    use UseDocumentTemplates;

    /**
     * Document templates data for testing
     * @var array
     */
    private array $document_templates = [
        [
            'name' => 'First template'
        ],
        [
            'name' => 'Second template'
        ]
    ];

    /**
     * Test getting document templates without parameters
     * Test case reproduce:
     * 1. Seed database
     * 2. Register simple user
     * 3. Create document templates for testing
     * 4. Create use case for getting, execute it and check, that all document templates was loaded from database
     *
     * Expected: All document templates was loaded from database
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testSimpleGettingDocumentTemplates(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user
        $user = $this->createUser();

        // 3. Create document templates for testing
        $document_templates = $this->createDocumentTemplatesForTesting($user);

        // 4. Create use case for getting, execute it and check, that all document templates was loaded from database
        /**
         * @var BaseUseCase&IGettingEntities $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::GET_DOCUMENT_TEMPLATES);
        $use_case->setInputDTO(new GetDocumentTemplatesDTO($user));
        $use_case->execute();

        $this->assertEquals(
            $this->document_templates[0]['name'],
            $use_case->getListDTO()->getModels()[0]->name
        );
        $this->assertEquals(
            $this->document_templates[1]['name'],
            $use_case->getListDTO()->getModels()[1]->name
        );

        $this->assertEquals(
            2,
            $use_case->getListDTO()->getCount()
        );

        $this->removeFilesForTemplates($document_templates);
    }

    /**
     * Test getting document templates with sorting
     * Test case reproduce:
     * 1. Seed database
     * 2. Register simple user
     * 3. Create document templates for testing
     * 4. Define input data with sorting
     * 5. Create use case for getting, execute it and check, that all document templates was loaded from database
     *  and was sorted
     *
     * Expected: All document templates was loaded from database and sorted by input data
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testGettingDocumentTemplatesWithSorting(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user
        $user = $this->createUser();

        // 3. Create document templates for testing
        $document_templates = $this->createDocumentTemplatesForTesting($user);

        // 4. Define input data with sorting
        $data = [
            'sort_by' => 'name',
            'sort_direction' => 'desc'
        ];
        $input_dto = (new GetDocumentTemplatesDTO($user))
            ->fill($data);

        // 5. Create use case for getting, execute it and check, that all document templates was loaded from database
        //    and was sorted
        /**
         * @var BaseUseCase&IGettingEntities $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::GET_DOCUMENT_TEMPLATES);
        $use_case->setInputDTO($input_dto);
        $use_case->execute();

        $this->assertEquals(
            $this->document_templates[1]['name'],
            $use_case->getListDTO()->getModels()[0]->name
        );
        $this->assertEquals(
            $this->document_templates[0]['name'],
            $use_case->getListDTO()->getModels()[1]->name
        );

        $this->assertEquals(
            2,
            $use_case->getListDTO()->getCount()
        );

        $this->removeFilesForTemplates($document_templates);
    }

    /**
     * Test getting document templates with sorting
     * Test case reproduce:
     * 1. Seed database
     * 2. Register simple user
     * 3. Create document templates for testing
     * 4. Define input data with pagination parameters
     * 5. Create use case for getting, execute it and check, that document templates was loaded from database
     *  and was cropped by pagination parameters
     *
     * Expected: Document templates was loaded from database and cropped by pagination parameters
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testGettingDocumentTemplatesWithLimitAndOffset(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user
        $user = $this->createUser();

        // 3. Create document templates for testing
        $document_templates = $this->createDocumentTemplatesForTesting($user);

        // 4. Define input data with pagination parameters
        $data = [
            'limit' => 1,
            'offset' => 1
        ];
        $input_dto = (new GetDocumentTemplatesDTO($user))
            ->fill($data);

        // 5. Create use case for getting, execute it and check, that document templates was loaded from database
        //    and was cropped by pagination parameters
        /**
         * @var BaseUseCase&IGettingEntities $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::GET_DOCUMENT_TEMPLATES);
        $use_case->setInputDTO($input_dto);
        $use_case->execute();

        $this->assertEquals(
            $this->document_templates[1]['name'],
            $use_case->getListDTO()->getModels()[0]->name
        );

        $this->assertEquals(
            2,
            $use_case->getListDTO()->getCount()
        );

        $this->removeFilesForTemplates($document_templates);
    }

    /**
     * Test getting document templates with sorting
     * Test case reproduce:
     * 1. Seed database
     * 2. Register simple user
     * 3. Create document templates for testing
     * 4. Register second user with company
     * 5. Define input data without parameters
     * 6. Create use case for getting document templates for second user, execute it and check,
     *  that document templates was loaded, but document templates is empty
     *
     * Expected: Document templates for second user was not found
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testGettingDocumentTemplatesWhenDocumentTemplatesWasCreatedForOtherOwner(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register simple user
        $user_1 = $this->createUser();

        // 3. Create document templates for testing
        $document_templates = $this->createDocumentTemplatesForTesting($user_1);

        // 4. Register second user with company
        $user_2 = $this->createUser($index = 1);

        // 5. Define input data without parameters
        $input_dto = new GetDocumentTemplatesDTO($user_2);

        // 6. Create use case for getting document templates for second user, execute it and check,
        // that document templates was loaded, but document templates is empty
        /**
         * @var BaseUseCase&IGettingEntities $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::GET_DOCUMENT_TEMPLATES);
        $use_case->setInputDTO($input_dto);
        $use_case->execute();

        $this->assertEquals(
            0,
            $use_case->getListDTO()->getCount()
        );

        $this->removeFilesForTemplates($document_templates);
    }
}
