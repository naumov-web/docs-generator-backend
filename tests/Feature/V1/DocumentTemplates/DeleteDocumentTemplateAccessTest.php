<?php

namespace Tests\Feature\V1\DocumentTemplates;

use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\DocumentTemplate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use Tests\Feature\BaseFeatureTest;
use Tests\Traits\UseDocumentTemplates;
use Tests\Traits\UseUserRegistration;

/**
 * Class DeleteDocumentTemplateAccessTest
 * @package Tests\Feature\V1\DocumentTemplates
 */
final class DeleteDocumentTemplateAccessTest extends BaseFeatureTest
{
    use UseUserRegistration, UseDocumentTemplates;

    /**
     * Route name for testing
     * @var string
     */
    public const ROUTE_NAME = 'v1.account.document_templates.delete';

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
     * Test case, when we try to delete document template from other owner
     * Test case reproduce:
     * 1. Seed database
     * 2. Register first user
     * 3. Create document template for first user
     * 4. Register second user
     * 5. Execute request for deleting of document template and check response code
     *
     * Expected result: API returns error with code 403
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testDeleteDocumentTemplateFromOtherOwner(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register first user
        $user_1 = $this->createUser();

        // 3. Create document template for first user
        $document_templates = $this->createDocumentTemplatesForTesting($user_1);
        /**
         * @var DocumentTemplate $document_template
         */
        $document_template = $document_templates->first();

        // 4. Register second user
        $user_2 = $this->createUser($index = 1);
        $this->signed_user = $user_2;

        // 5. Execute request for deleting of document template and check response code
        $this->json(
            $method = 'DELETE',
            route(self::ROUTE_NAME, ['document_template' => $document_template->id]),
        )->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
