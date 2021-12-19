<?php

namespace Tests\Unit\ValidationRules;

use App\DTO\Input\Auth\RegisterUserDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\User;
use App\Rules\EmailNotExists;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\BaseValidationRuleTest;

/**
 * Class EmailAlreadyExistsTest
 * @package Tests\Unit\ValidationRules
 */
final class EmailAlreadyExistsTest extends BaseValidationRuleTest
{
    /**
     * Test case when user with email not registered and already registered
     * Test case reproduce:
     * 1. Seed database
     * 2. Define user data and register new user
     * 3. Create validation class instance
     * 4. Run validation method with email from defined user data
     * 5. Create validation class instance with except user id
     * 6. Run validation method with email from defined user data
     *
     * Expected: Validation result is false for first checking, Validation result is true for second checking
     * @test
     * @return void
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testWhenUserWithEmailNotRegisteredAndAlreadyRegistered(): void
    {
        // 1. Seed database
        $this->seedDatabase();
        $this->init();

        // 2. Define user data and register new user
        $user_data = [
            'email' => 'email1@email.com',
            'password' => 'qweasd',
            'password_confirmation' => 'qweasd',
        ];
        $register_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $register_use_case->setInputDTO(
            (new RegisterUserDTO())->fill($user_data)
        );
        $register_use_case->execute();

        /**
         * @var User $user
         */
        $user = User::query()->where('email', $user_data['email'])->first();

        // 3. Create validation class instance
        $validator = new EmailNotExists();

        // 4. Run validation method with email from defined user data
        $this->assertFalse($validator->passes('email', $user_data['email']));

        // 5. Create validation class instance with except user id
        $validator = new EmailNotExists($user->id);

        // 6. Run validation method with email from defined user data
        $this->assertTrue($validator->passes('email', $user_data['email']));
    }
}
