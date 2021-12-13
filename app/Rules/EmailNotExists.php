<?php

declare(strict_types=1);

namespace App\Rules;

use App\DTO\Common\FilterDTO;
use App\Repositories\UsersRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class EmailNotExists
 * @package App\Rules
 */
final class EmailNotExists implements Rule
{
    /**
     * Users repository instance
     * @var UsersRepository
     */
    private UsersRepository $repository;

    /**
     * Except id value
     * @var int|null
     */
    private int|null $except_id;

    /**
     * EmailNotExists constructor
     * @param int|null $except_id
     * @throws BindingResolutionException
     */
    public function __construct(int $except_id = null)
    {
        $this->except_id = $except_id;

        $this->repository = app()->make(UsersRepository::class);
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        if ($value) {
            $filters = [new FilterDTO('email', '=', $value)];

            if ($this->except_id) {
                $filters[] = new FilterDTO('id', '<>', $this->except_id);
            }

            return $this->repository->getCountByFilters($filters) === 0;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return __('validation.email_already_registered');
    }
}
