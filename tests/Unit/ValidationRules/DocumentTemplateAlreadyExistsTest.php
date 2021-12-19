<?php

namespace Tests\Unit\ValidationRules;

use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\DocumentTemplate;
use App\Rules\DocumentTemplateNotExists;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\BaseValidationRuleTest;

/**
 * Class DocumentTemplateAlreadyExistsTest
 * @package Tests\Unit\ValidationRules
 */
final class DocumentTemplateAlreadyExistsTest extends BaseValidationRuleTest
{
    /**
     * Test when document template with name not exists and exists
     * Test case reproduce:
     * 1. Seed database
     * 2. Register new user
     * 3. Create validation class instance
     * 4. Run validation with name, which not exists for current user
     * 5. Create document template for current user
     * 6. Run validation with name, which exists for current user
     *
     * Expected: Validation result is true for first checking, Validation result is false for second checking
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testWhenDocumentTemplateWithNameNotExistsAndExists(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Register new user
        $user = $this->createUser();

        // 3. Create validation class instance
        $template_name = 'Template 1';
        $validator = new DocumentTemplateNotExists($user);

        // 4. Run validation with name, which not exists for current user
        $this->assertTrue($validator->passes('name', $template_name));

        // 5. Create document template for current user
        DocumentTemplate::query()->create([
            'name' => $template_name,
            'owner_id' => $user->id,
            'owner_type' => get_class($user)
        ]);

        // 6. Run validation with name, which exists for current user
        $this->assertFalse($validator->passes('name', $template_name));
    }
}
