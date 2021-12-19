<?php

namespace Tests\Unit;

use App\UseCases\UseCaseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\BaseTest;
use Tests\Traits\UseUserRegistration;

/**
 * Class BaseUseCaseTest
 * @package Tests\Unit;
 */
abstract class BaseUseCaseTest extends BaseTest
{
    use UseUserRegistration;

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
