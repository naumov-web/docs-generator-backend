<?php

declare(strict_types=1);

namespace App\DTO\Input\DocumentTemplates;

use App\DTO\BaseInputDTO;
use App\DTO\Common\FileDTO;
use App\Models\User;

/**
 * Class CreateDocumentTemplateDTO
 * @package App\DTO\Input\DocumentTemplates
 */
final class CreateDocumentTemplateDTO extends BaseInputDTO
{
    /**
     * Name value
     * @var string
     */
    private string $name;

    /**
     * File DTO instance
     * @var FileDTO
     */
    private FileDTO $file;

    /**
     * User instance
     * @var User
     */
    private User $user;

    /**
     * CreateDocumentTemplateDTO constructor
     * @param string $name
     * @param FileDTO $file
     * @param User $user
     */
    public function __construct(string $name, FileDTO $file, User $user)
    {
        $this->name = $name;
        $this->file = $file;
        $this->user = $user;
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

    /**
     * Get file DTO instance
     *
     * @return FileDTO
     */
    public function getFile(): FileDTO
    {
        return $this->file;
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
