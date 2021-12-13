<?php

declare(strict_types=1);

namespace App\DTO\Common;

/**
 * Class IndexDTO
 * @package App\DTO
 */
final class IndexDTO
{

    /**
     * Limit value
     * @var int|null
     */
    private $limit = null;

    /**
     * Offset value
     * @var int|null
     */
    private $offset = null;

    /**
     * Filters array
     * @var array
     */
    private $filters = [];

    /**
     * Sort by column
     * @var string|null
     */
    private $sort_by = null;

    /**
     * Sort direction value
     * @var string|null
     */
    private $sort_direction = null;

    /**
     * Connectable entities list
     * @var array|null
     */
    private $with = null;

    /**
     * With trashed flag
     * @var bool
     */
    private $with_trashed = false;

    /**
     * Mass assignment of object fields
     *
     * @param array $fields
     * @return IndexDTO
     */
    public function fill(array $fields): self
    {
        foreach ($fields as $field => $value) {
            $this->{$field} = $value;
        }

        return $this;
    }

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
     * Get sort direction value
     *
     * @return string|null
     */
    public function getSortDirection(): ?string
    {
        return $this->sort_direction;
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
     * Get array with filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Get connectable entities list
     *
     * @return array|null
     */
    public function getWith(): ?array
    {
        return $this->with;
    }

    /**
     * Set connectable entities list
     *
     * @param array $with
     * @return $this
     */
    public function setWith(array $with): self
    {
        $this->with = $with;

        return $this;
    }

    /**
     * Set with_trashed flag value
     *
     * @param bool $with_trashed
     * @return $this
     */
    public function setWithTrashed(bool $with_trashed): self
    {
        $this->with_trashed = $with_trashed;

        return $this;
    }

    /**
     * Get with_trashed flag value
     *
     * @return bool
     */
    public function getWithTrashed(): bool
    {
        return $this->with_trashed;
    }

    /**
     * Set filters
     *
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Add filter
     *
     * @param FilterDTO $filter
     * @return $this
     */
    public function addFilter(FilterDTO $filter): self
    {
        $this->filters[] = $filter;

        return $this;
    }
}
