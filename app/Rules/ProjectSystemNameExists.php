<?php

namespace App\Rules;

use App\DTO\Common\FilterDTO;
use App\Repositories\ProjectsRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class ProjectSystemNameExists
 * @package App\Rules
 */
final class ProjectSystemNameExists implements Rule
{
    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function passes($attribute, $value): bool
    {
        /**
         * @var ProjectsRepository $repository
         */
        $repository = ProjectsRepository::getInstance();

        if ($value) {
            return $repository->getCountByFilters([new FilterDTO('system_name', '=', $value)]) === 0;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return __('validation.project_system_name_already_exists');
    }
}
