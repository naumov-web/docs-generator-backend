<?php

namespace Tests\Unit;

use App\UseCases\UseCaseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\BaseTest;

/**
 * Class BaseUseCaseTest
 * @package Tests\Unit;
 */
abstract class BaseUseCaseTest extends BaseTest
{
    /**
     * Use case factory instance
     * @var UseCaseFactory
     */
    protected UseCaseFactory $use_case_factory;

    /**
     * Init test instance
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function init(): void
    {
        $this->use_case_factory = app()->make(UseCaseFactory::class);
    }
}
