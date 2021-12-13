<?php

namespace App\DTO\Input\User;

use App\DTO\BaseInputDTO;
use App\Models\User;

/**
 * Class UpdateSpecificUserDTO
 * @package App\DTO\Input\Users
 */
final class UpdateSpecificUserDTO extends BaseInputDTO
{
    /**
     * Users instance
     * @var User
     */
    private User $user;

    /**
     * Email value
     * @var string|null
     */
    private string|null $email = null;

    /**
     * Password value
     * @var string|null
     */
    private string|null $password = null;

    /**
     * First name value
     * @var string|null
     */
    private string|null $first_name = null;

    /**
     * Surname value
     * @var string|null
     */
    private string|null $surname = null;

    /**
     * Last name value
     * @var string|null
     */
    private string|null $last_name = null;

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

    /**
     * Get email value
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Get password value
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Get first name value
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * Get surname value
     *
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * Get last name value
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }
}
