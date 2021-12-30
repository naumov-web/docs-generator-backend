<?php

namespace App\Models\Contracts;

/**
 * Interface IHasOwner
 * @package App\Models\Contracts
 */
interface IHasOwner
{
    /**
     * Get owner id
     *
     * @return int
     */
    public function getOwnerId(): int;

    /**
     * Get owner type
     *
     * @return string
     */
    public function getOwnerType(): string;
}
