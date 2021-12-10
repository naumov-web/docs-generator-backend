<?php

namespace Tests\Unit\Auth;

use App\DTO\Input\Auth\LoginDTO;
use App\DTO\Input\Auth\RegisterUserDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\RegisterUseCase;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\BaseUseCaseTest;

/**
 * Class LoginUseCaseTest
 * @package Tests\Unit\Auth
 */
final class LoginUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test login of user with incorrect data
     * Test case reproduce:
     * 1. Seed database
     * 2. Define input data
     * 3. Create RegisterUseCase instance, load input data and execute
     * 4. Try LoginUseCase instance, load input data and execute
     *
     * Expected: LoginUseCase throws exception AuthorizationException, use case not returns token instance
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws AuthorizationException
     */
    public function testLoginUserFail(): void
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
         * @var RegisterUseCase $register_use_case
         */
        $register_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $register_use_case->setInputDTO((new RegisterUserDTO())->fill($data))
            ->execute();

        // 4. Try LoginUseCase instance, load input data and execute
        $this->expectException(AuthorizationException::class);
        /**
         * @var LoginUseCase $login_use_case
         */
        $login_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::LOGIN);
        $login_use_case
            ->setInputDTO(
                (new LoginDTO())
                    ->fill([
                        'email' => $data['email'],
                        'password' => $data['password'] . '!',
                    ])
            )
            ->execute();

        $this->assertNull($login_use_case->getToken());
    }

    /**
     * Test login of user with correct data
     * Test case reproduce:
     * 1. Seed database
     * 2. Define input data
     * 3. Create RegisterUseCase instance, load input data and execute
     * 4. Try LoginUseCase instance, load input data and execute
     *
     * Expected: LoginUseCase not throws exception, use case returns token instance
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws AuthorizationException
     */
    public function testLoginUserSuccess(): void
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
         * @var RegisterUseCase $register_use_case
         */
        $register_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $register_use_case->setInputDTO((new RegisterUserDTO())->fill($data))
            ->execute();

        // 4. Try LoginUseCase instance, load input data and execute
        /**
         * @var LoginUseCase $login_use_case
         */
        $login_use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::LOGIN);
        $login_use_case->setInputDTO((new LoginDTO())->fill($data))
            ->execute();

        // Check that token is not null
        $this->assertNotNull($login_use_case->getToken());
    }
}
