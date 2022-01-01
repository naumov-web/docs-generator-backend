<?php

namespace Tests;

use App\UseCases\UseCaseFactory;
use Database\Seeders\RolesSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

/**
 * Class BaseTest
 * @package Tests
 */
abstract class BaseTest extends TestCase
{
    use RefreshDatabase;

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
        Queue::fake();
    }

    /**
     * Seed database
     *
     * @return void
     */
    protected function seedDatabase(): void
    {
        $this->seed(RolesSeeder::class);
    }
}
