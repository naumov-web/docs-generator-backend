<?php

namespace App\Models\Traits;

/**
 * Trait HasOwner
 * @package App\Models\Traits
 */
trait HasOwner
{
    /**
     * Get owner id
     *
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * Get owner type
     *
     * @return string
     */
    public function getOwnerType(): string
    {
        return $this->owner_type;
    }
}
