<?php

namespace App\UseCases\Contracts;

use App\DTO\Common\ListItemsDTO;

/**
 * Interface IGettingEntities
 * @package App\UseCases\Contracts
 */
interface IGettingEntities
{
    /**
     * Get list DTO instance
     *
     * @return ListItemsDTO
     */
    public function getListDTO(): ListItemsDTO;
}
