<?php

declare(strict_types=1);

namespace App\UseCases\Traits;

use Illuminate\Support\Facades\Hash;

/**
 * Trait UsePassword
 * @package App\UseCases\Traits
 */
trait UsePassword
{
    /**
     * Get password hash
     *
     * @param string $password
     * @return string
     */
    protected function getPasswordHash(string $password): string
    {
        return Hash::make($password);
    }
}
