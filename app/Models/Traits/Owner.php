<?php

namespace App\Models\Traits;

/**
 * Trait Owner
 * @package App\Models\Traits
 */
trait Owner
{
    /**
     * Get model id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get model type
     *
     * @return string
     */
    public function getType(): string
    {
        return get_class($this);
    }
}
