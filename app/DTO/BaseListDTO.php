<?php

namespace App\DTO;

/**
 * Class BaseListDTO
 * @package App\DTO
 */
abstract class BaseListDTO extends BaseDTO
{
    /**
     * Limit value
     * @var int|null
     */
    protected int|null $limit = null;

    /**
     * Offset value
     * @var int|null
     */
    protected int|null $offset = null;

    /**
     * Sort by value
     * @var string|null
     */
    protected string|null $sort_by = null;

    /**
     * Sort direction value
     * @var string|null
     */
    protected string|null $sort_direction = null;

    /**
     * Get offset value
     *
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Get limit value
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Get sort column
     *
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sort_by;
    }

    /**
     * Get sort direction value
     *
     * @return string|null
     */
    public function getSortDirection(): ?string
    {
        return $this->sort_direction;
    }
}
