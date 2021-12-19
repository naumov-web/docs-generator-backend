<?php

declare(strict_types=1);

namespace App\Rules;

use App\DTO\Common\FilterDTO;
use App\Models\User;
use App\Repositories\DocumentTemplatesRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class DocumentTemplateNotExists
 * @package App\Rules
 */
final class DocumentTemplateNotExists implements Rule
{
    /**
     * User instance
     * @var User
     */
    private User $user;

    /**
     * Document templates repository instance
     * @var DocumentTemplatesRepository
     */
    private DocumentTemplatesRepository $document_templates_repository;

    /**
     * DocumentTemplateNotExists constructor
     * @param User $user
     * @throws BindingResolutionException
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->document_templates_repository = app()->make(DocumentTemplatesRepository::class);
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        $first_company = $this->user->first_company;
        $owner = $first_company ?? $this->user;
        $filters = [
            new FilterDTO('owner_type', '=', get_class($owner)),
            new FilterDTO('owner_id', '=', $owner->id),
            new FilterDTO('name', '=', $value),
        ];

        return $this->document_templates_repository->getCountByFilters($filters) === 0;
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return __('validation');
    }
}
