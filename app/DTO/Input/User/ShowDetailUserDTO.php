<?php

namespace App\DTO\Input\User;

use App\DTO\BaseInputDTO;
use App\Models\User;

/**
 * Class ShowDetailUserDTO
 * @package App\DTO\Input\User
 */
final class ShowDetailUserDTO extends BaseInputDTO
{
    /**
     * User instance
     * @var User
     */
    private User $user;

    /**
     * ShowDetailUserDTO constructor
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user instance
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
