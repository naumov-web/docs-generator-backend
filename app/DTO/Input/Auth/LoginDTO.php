<?php

namespace App\DTO\Input\Auth;

use App\DTO\BaseInputDTO;

/**
 * Class LoginDTO
 * @package App\DTO\Input\Auth
 */
final class LoginDTO extends BaseInputDTO
{
    /**
     * Users email value
     * @var string
     */
    protected string $email;

    /**
     * Users password value
     * @var string
     */
    protected string $password;

    /**
     * Get email value
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get password value
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
