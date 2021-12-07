<?php

namespace Tests\Unit\Auth;

use App\DTO\Input\Auth\RegisterUserDTO;
use App\Enums\RoleSystemNamesEnum;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\UseCases\Auth\RegisterUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\BaseUseCaseTest;

/**
 * Class RegisterUseCaseTest
 * @package Tests\Unit\Auth
 */
final class RegisterUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test registration of simple user
     * Test case reproduce:
     * 1. Seed database
     * 2. Define input data
     * 3. Create RegisterUseCase instance, load input data and execute
     *
     * Expected: New user was created and role USER was attached to it
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     * @throws InvalidInputDTOException
     */
    public function testRegisterSimpleUser(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Define input data
        $data = [
            'email' => 'email1@email.com',
            'password' => 'qweasd',
            'password_confirmation' => 'qweasd'
        ];

        // 3. Create RegisterUseCase instance, load input data and execute
        /**
         * @var RegisterUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $use_case->setInputDTO((new RegisterUserDTO())->fill($data))
            ->execute();

        // Check, that use was created
        /**
         * @var User $user
         */
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        $this->assertNotNull($user);

        // Check that role USER was attached to new user
        $this->assertEquals(
            Role::query()->where('system_name', RoleSystemNamesEnum::USER)->first()->id,
            $user->roles()->first()->id
        );
    }

    /**
     * Test registration of company owner
     * Test case reproduce:
     * 1. Seed database
     * 2. Define input data
     * 3. Create RegisterUseCase instance, load input data and execute
     *
     * Expected: New user was created, role COMPANY_OWNER was attached to it,
     * new company was created and new user was attached to new company
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     * @throws InvalidInputDTOException
     */
    public function testRegisterCompanyOwner(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Define input data
        $data = [
            'email' => 'company@email.com',
            'password' => 'qweasd',
            'password_confirmation' => 'qweasd',
            'company_name' => 'New company'
        ];

        // 3. Create RegisterUseCase instance, load input data and execute
        /**
         * @var RegisterUseCase $use_case
         */
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $use_case->setInputDTO((new RegisterUserDTO())->fill($data))
            ->execute();

        // Check that use was created
        /**
         * @var User $user
         */
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        $this->assertNotNull($user);

        // Check that role COMPANY_OWNER was attached to new user
        $this->assertEquals(
            Role::query()->where('system_name', RoleSystemNamesEnum::COMPANY_OWNER)->first()->id,
            $user->roles()->first()->id
        );

        // Check that new company was created
        /**
         * @var Company $company
         */
        $company = Company::query()
            ->where('name', $data['company_name'])
            ->first();

        $this->assertNotNull($company);

        // Check that new company was attached to new user
        $this->assertEquals(
            $company->id,
            $user->companies()->first()->id
        );
    }
}
