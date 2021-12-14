<?php

namespace Tests\Unit\User;

use App\DTO\Input\Auth\LoginDTO;
use App\DTO\Input\Auth\RegisterUserDTO;
use App\DTO\Input\User\UpdateSpecificUserDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\User;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\RegisterUseCase;
use App\UseCases\Users\UpdateSpecificUserUseCase;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\BaseUseCaseTest;

/**
 * Class UpdateSpecificUserUseCaseTest
 * @package Tests\Unit\User
 */
final class UpdateSpecificUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test updating of user fields except of password field
     * Test case reproduce:
     * 1. Seed database
     * 2. Define user data and register new user
     * 3. Create use case for updating of specific user
     * 4. Define new user data
     * 5. Execute use case
     * 6. Check that user was changed
     *
     * Expected: User fields was changed
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     */
    public function testUpdatingWithoutPassword(): void
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
        $user = User::query()
            ->where('email', $user_data['email'])
            ->first();

        // 3. Create use case for updating of specific user
        $update_user_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::UPDATE_SPECIFIC_USER);

        // 4. Define new user data
        $new_user_data = [
            'email' => 'email2@email.com',
            'first_name' => 'Name 1',
            'surname' => 'Surname 1',
            'last_name' => 'Last name 1',
        ];

        // 5. Execute use case
        $update_user_use_case->setInputDTO(
            (new UpdateSpecificUserDTO($user))
                ->fill($new_user_data)
        );
        $update_user_use_case->execute();

        // 6. Check that user was changed
        $user->refresh();

        $this->assertEquals($new_user_data['email'], $user->email);
        $this->assertEquals($new_user_data['first_name'], $user->first_name);
        $this->assertEquals($new_user_data['surname'], $user->surname);
        $this->assertEquals($new_user_data['last_name'], $user->last_name);
    }

    /**
     * Test updating of user fields with password field
     * Test case reproduce:
     * 1. Seed database
     * 2. Define user data and register new user
     * 3. Create use case for updating of specific user
     * 4. Define new user data
     * 5. Execute use case
     * 6. Check that password was changed
     *
     * Expected: User password was changed, authorization works correctly via new credentials
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws AuthorizationException
     */
    public function testUpdatingWithPassword(): void
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
        $user = User::query()
            ->where('email', $user_data['email'])
            ->first();

        // 3. Create use case for updating of specific user
        $update_user_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::UPDATE_SPECIFIC_USER);

        // 4. Define new user data
        $new_user_data = [
            'email' => 'email1@email.com',
            'password' => 'new password!'
        ];

        // 5. Execute use case
        $update_user_use_case->setInputDTO(
            (new UpdateSpecificUserDTO($user))
                ->fill($new_user_data)
        );
        $update_user_use_case->execute();

        // 6. Check that password was changed
        /**
         * @var LoginUseCase $login_use_case
         */
        $login_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::LOGIN);

        // 6.1 Try login via new credentials
        $login_use_case->setInputDTO(
            (new LoginDTO())->fill($new_user_data)
        );
        $login_use_case->execute();

        $this->assertNotNull($login_use_case->getToken());

        // 6.2 Try login via old credentials
        $this->expectException(AuthorizationException::class);
        $login_use_case->setInputDTO(
            (new LoginDTO())->fill($user_data)
        );
        $login_use_case->execute();
    }
}
