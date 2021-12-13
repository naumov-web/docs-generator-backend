<?php

declare(strict_types=1);

namespace App\UseCases\Users;

use App\DTO\Input\User\ShowDetailUserDTO;
use App\Models\User;
use App\UseCases\BaseUseCase;

/**
 * Class ShowDetailUserUseCase
 * @package App\UseCases\Users;
 */
final class ShowDetailUserUseCase extends BaseUseCase
{

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return ShowDetailUserDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
    }

    /**
     * Get user instance
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->input_dto->getUser();
    }
}
