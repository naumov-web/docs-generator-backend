<?php

namespace App\DTO\Input;

use App\DTO\BaseListDTO;
use App\DTO\Common\IndexDTO;

/**
 * Class BaseListInputDTO
 * @package App\DTO\Input
 */
abstract class BaseListInputDTO extends BaseListDTO
{
    /**
     * Get index DTO instance
     *
     * @return IndexDTO
     */
    public function getIndexDTO(): IndexDTO
    {
        return (new IndexDTO())
            ->fill([
                'limit' => $this->getLimit(),
                'offset' => $this->getOffset(),
                'sort_by' => $this->getSortBy(),
                'sort_direction' => $this->getSortDirection(),
            ]);
    }
}
