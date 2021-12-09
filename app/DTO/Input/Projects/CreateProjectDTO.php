<?php

namespace App\DTO\Input\Projects;

use App\DTO\BaseInputDTO;
use App\Models\User;

/**
 * Class CreateProjectDTO
 * @package App\DTO\Input\Projects
 */
final class CreateProjectDTO extends BaseInputDTO
{
    /**
     * User instance
     * @var User
     */
    protected User $user;

    /**
     * Project system name value
     * @var string
     */
    protected string $system_name;

    /**
     * Project name value
     * @var string
     */
    protected string $name;

    /**
     * CreateProjectDTO constructor
     * @param User $user
     * @param string $system_name
     * @param string $name
     */
    public function __construct(User $user, string $system_name, string $name)
    {
        $this->user = $user;
        $this->system_name = $system_name;
        $this->name = $name;
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
     * Get system name value
     *
     * @return string
     */
    public function getSystemName(): string
    {
        return $this->system_name;
    }

    /**
     * Get name value
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
