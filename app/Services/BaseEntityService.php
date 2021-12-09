<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseEntityService
 * @package App\Services
 */
abstract class BaseEntityService
{
    /**
     * Get instance of service
     *
     * @return static
     * @throws BindingResolutionException
     */
    public static function getInstance(): self
    {
        return app()->make(self::class);
    }
}
