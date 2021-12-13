<?php

declare(strict_types=1);

namespace App\DTO\Input\Auth;

use App\DTO\BaseInputDTO;

/**
 * Class RegisterUserDTO
 * @package App\DTO\Input\Auth
 */
final class RegisterUserDTO extends BaseInputDTO
{
    /**
     * New user email value
     * @var string
     */
    protected string $email;

    /**
     * New user password value
     * @var string
     */
    protected string $password;

    /**
     * New user company name value
     * @var string|null
     */
    protected string|null $company_name = null;

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

    /**
     * Get company name value
     *
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }
}
