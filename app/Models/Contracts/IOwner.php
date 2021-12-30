<?php

namespace App\Models\Contracts;

/**
 * Interface IOwner
 * @package App\Models\Contracts
 */
interface IOwner
{
    /**
     * Get model id
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Get model type
     *
     * @return string
     */
    public function getType(): string;
}
