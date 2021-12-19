<?php

namespace Tests\Traits;

use App\DTO\Input\Auth\RegisterUserDTO;
use App\Enums\UseCaseSystemNamesEnum;
use App\Exceptions\InvalidInputDTOException;
use App\Exceptions\UseCaseNotFoundException;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class UseUserRegistration
 * @package Tests\Traits
 */
trait UseUserRegistration
{
    /**
     * Users data for testing
     * @var array
     */
    protected array $users_data = [
        [
            'email' => 'user1@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ],
        [
            'email' => 'user2@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'company_name' => 'Company one'
        ],
    ];

    /**
     * Create user by test users data
     *
     * @param int $index
     * @return User
     * @throws InvalidInputDTOException
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    protected function createUser(int $index = 0): User
    {
        $use_case = $this->use_case_factory->createUseCase(UseCaseSystemNamesEnum::REGISTER);
        $use_case->setInputDTO(
            (new RegisterUserDTO())->fill($this->users_data[$index])
        );
        $use_case->execute();

        /**
         * @var User $user
         */
        $user = User::query()->where('email', $this->users_data[$index]['email'])->first();

        return $user;
    }
}
