<?php

namespace Tests;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class BaseTest
 * @package Tests
 */
abstract class BaseTest extends TestCase
{
    use RefreshDatabase;

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
