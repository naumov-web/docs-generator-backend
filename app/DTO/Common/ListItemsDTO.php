<?php

namespace App\DTO\Common;

use Illuminate\Support\Collection;

/**
 * Class ListItemsDTO
 * @package App\DTO
 */
final class ListItemsDTO
{

    /**
     * Count of all items
     * @var int
     */
    private $count;

    /**
     * Collection of models
     * @var Collection
     */
    private $models;

    /**
     * ListItemsDTO constructor.
     * @param Collection $models
     * @param int $count
     */
    public function __construct(Collection $models, int $count)
    {
        $this->models = $models;
        $this->count = $count;
    }

    /**
     * Get models
     *
     * @return Collection
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    /**
     * Get count
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

}
