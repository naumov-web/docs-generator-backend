<?php

declare(strict_types=1);

namespace App\UseCases\Users;

use App\DTO\Input\User\UpdateSpecificUserDTO;
use App\Repositories\UsersRepository;
use App\UseCases\BaseUseCase;
use App\UseCases\Traits\UsePassword;

/**
 * Class UpdateSpecificUserUseCase
 * @package App\UseCases\Users
 */
final class UpdateSpecificUserUseCase extends BaseUseCase
{
    use UsePassword;

    /**
     * Users repository instance
     * @var UsersRepository
     */
    private UsersRepository $repository;

    /**
     * UpdateSpecificUserUseCase constructor
     * @param UsersRepository $repository
     */
    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return UpdateSpecificUserDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $data = [
            'email' => $this->input_dto->getEmail(),
            'first_name' => $this->input_dto->getFirstName(),
            'surname' => $this->input_dto->getSurname(),
            'last_name' => $this->input_dto->getLastName(),
        ];

        if ($this->input_dto->getPassword()) {
            $data['password'] = $this->getPasswordHash($this->input_dto->getPassword());
        }

        $this->repository->update(
            $this->input_dto->getUser(),
            $data
        );
    }
}
