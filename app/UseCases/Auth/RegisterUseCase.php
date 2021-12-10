<?php

namespace App\UseCases\Auth;

use App\DTO\Common\FilterDTO;
use App\DTO\Input\Auth\RegisterUserDTO;
use App\Enums\RoleSystemNamesEnum;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CompaniesRepository;
use App\Repositories\RolesRepository;
use App\Repositories\UsersRepository;
use App\UseCases\BaseUseCase;
use App\UseCases\Traits\UsePassword;

/**
 * Class RegisterUseCase
 * @package App\UseCases\Auth
 */
final class RegisterUseCase extends BaseUseCase
{
    use UsePassword;

    /**
     * Users repository instance
     * @var UsersRepository
     */
    private UsersRepository $users_repository;

    /**
     * Roles repository instance
     * @var RolesRepository
     */
    private RolesRepository $roles_repository;

    /**
     * Companies repository instance
     * @var CompaniesRepository
     */
    private CompaniesRepository $companies_repository;

    /**
     * RegisterUseCase constructor
     * @param UsersRepository $users_repository
     * @param RolesRepository $roles_repository
     * @param CompaniesRepository $companies_repository
     */
    public function __construct(
        UsersRepository $users_repository,
        RolesRepository $roles_repository,
        CompaniesRepository $companies_repository
    )
    {
        $this->users_repository = $users_repository;
        $this->roles_repository = $roles_repository;
        $this->companies_repository = $companies_repository;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return RegisterUserDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        if ($this->input_dto->getCompanyName()) {
            $this->registerCompanyOwner();
        } else {
            $this->registerSimpleUser();
        }
    }

    /**
     * Register company owner
     *
     * @return void
     */
    private function registerCompanyOwner(): void
    {
        $user = $this->registerSimpleUser();
        /**
         * @var Company $company
         */
        $company = $this->companies_repository->store([
            'name' => $this->input_dto->getCompanyName()
        ]);

        $user->companies()->sync([
            $company->id
        ]);
    }

    /**
     * Register simple user
     *
     * @return User
     */
    private function registerSimpleUser(): User
    {
        $user_data = [
            'email' => $this->input_dto->getEmail(),
            'password' => $this->getPasswordHash($this->input_dto->getPassword())
        ];

        /**
         * @var User $user
         */
        $user = $this->users_repository->store($user_data);

        if (!$this->input_dto->getCompanyName()) {
            /**
             * @var Role $role
             */
            $role = $this->roles_repository->getFirstByFilters([
                new FilterDTO('system_name', '=', RoleSystemNamesEnum::USER)
            ]);
        } else {
            /**
             * @var Role $role
             */
            $role = $this->roles_repository->getFirstByFilters([
                new FilterDTO('system_name', '=', RoleSystemNamesEnum::COMPANY_OWNER)
            ]);
        }

        $user->roles()->sync([
            $role->id
        ]);

        return $user;
    }
}
