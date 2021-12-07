<?php

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
     * EmailNotExists constructor
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->repository = app()->make(UsersRepository::class);
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        if ($value) {
            $count = $this->repository->getCountByFilters([
                new FilterDTO('email', '=', $value)
            ]);

            return $count === 0;
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
