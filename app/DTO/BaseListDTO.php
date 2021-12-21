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
    protected int|null $limit;

    /**
     * Offset value
     * @var int|null
     */
    protected int|null $offset;

    /**
     * Sort by value
     * @var string|null
     */
    protected string|null $sort_by;

    /**
     * Sort direction value
     * @var string|null
     */
    protected string|null $sort_direction;

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
