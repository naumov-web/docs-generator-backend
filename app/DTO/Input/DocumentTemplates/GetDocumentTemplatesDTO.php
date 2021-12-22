<?php

namespace App\DTO\Input\DocumentTemplates;

use App\DTO\Input\BaseListInputDTO;
use App\Models\User;

/**
 * Class GetDocumentTemplatesDTO
 * @package App\DTO\Input\DocumentTemplates
 */
final class GetDocumentTemplatesDTO extends BaseListInputDTO
{
    /**
     * User instance
     * @var User
     */
    private User $user;

    /**
     * GetDocumentTemplatesDTO constructor
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
