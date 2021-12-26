<?php

namespace App\Repositories;

use App\DTO\Common\FilterDTO;
use App\DTO\Common\IndexDTO;
use App\DTO\Common\ListItemsDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository
{
    /**
     * Get model class name
     *
     * @return string
     */
    protected abstract function getModelClass(): string;

    /**
     * Get primary key name
     *
     * @return string
     */
    public function getKeyName(): string
    {
        $class = $this->getModelClass();

        return (new $class())->getKeyName();
    }

    /**
     * Apply filters to query
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    protected function applyFilters(Builder $query, array $filters): Builder
    {
        foreach($filters as $filter) {
            /**
             * @var FilterDTO $filter
             */
            if ($filter->getArgumentsCount() == 2) {

                if ($filter->getOperation() == 'IS NOT NULL') {
                    $query->whereNotNull($filter->getField());
                    continue;
                }

                if ($filter->getOperation() == 'IS NULL') {
                    $query->whereNull($filter->getField());
                    continue;
                }
            }

            if ($filter->getArgumentsCount() == 3) {

                if ($filter->getOperation() == 'IN') {
                    $query->whereIn($filter->getField(), $filter->getValue());
                    continue;
                }

                if ($filter->getOperation() == 'NOT IN') {
                    $query->whereNotIn($filter->getField(), $filter->getValue());
                    continue;
                }

                $query->where($filter->getField(), $filter->getOperation(), $filter->getValue());
            }
        }

        return $query;
    }

    /**
     * Apply pagination to query
     *
     * @param Builder $query
     * @param IndexDTO $data
     * @return Builder
     */
    protected function applyPagination(Builder $query, IndexDTO $data): Builder
    {
        if ($data->getLimit()) {
            $query->limit($data->getLimit());
        }

        if ($data->getOffset()) {
            $query->offset($data->getOffset());
        }

        return $query;
    }

    /**
     * Apply default sorting
     *
     * @param Builder $query
     * @param IndexDTO $data
     * @return Builder
     */
    protected function applyDefaultSorting(Builder $query, IndexDTO $data): Builder
    {
        if ($data->getSortBy() && $data->getSortDirection()) {
            $query->orderBy($data->getSortBy(), $data->getSortDirection());
        }

        return $query;
    }

    /**
     * Get count and list of items
     *
     * @param IndexDTO|null $data
     * @param Builder|null $origin
     * @return ListItemsDTO
     */
    public function index(IndexDTO $data = null, Builder $origin = null): ListItemsDTO
    {
        if ($origin) {
            $query = $origin;
        } else {
            $model_class = $this->getModelClass();

            /**
             * @var Builder $query
             */
            $query = $model_class::query();
        }

        if ($data) {
            $query = $this->applyFilters($query, $data->getFilters());
        }

        if ($data && $data->getWithTrashed()) {
            $query->withTrashed();
        }

        $count = $query->count();

        if ($data && $data->getWith()) {
            $query->with($data->getWith());
        }

        if ($data) {
            $query = $this->applyPagination($query, $data);
            $query = $this->applyDefaultSorting($query, $data);
        }

        return new ListItemsDTO($query->get(), $count);
    }

    /**
     * Store new model to database
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        $model_class = $this->getModelClass();

        /**
         * @var Model $model
         */
        $model = new $model_class();
        $model->fill($data);
        $model->save();

        return $model;
    }

    /**
     * Update model
     *
     * @param Model $model
     * @param array $data
     * @param bool $update_timestamps
     * @return Model
     */
    public function update(Model $model, array $data, bool $update_timestamps = true): Model
    {
        if (!$update_timestamps) {
            $model->timestamps = false;
        }

        $model->update($data);
        $model->refresh();

        return $model;
    }

    /**
     * Get detailed model info
     *
     * @param Model $model
     * @return Model
     */
    public function show(Model $model): Model
    {
        return $model;
    }

    /**
     * Delete model
     *
     * @param Model $model
     * @param bool $is_force
     * @return bool
     */
    public function delete(Model $model, bool $is_force = false): bool
    {
        if ($is_force) {
            return $model->forceDelete();
        } else {
            return $model->delete();
        }
    }

    /**
     * Get first model by simple filters
     *
     * @param array $filters
     * @return Model|null
     */
    public function getFirstByFilters(array $filters): ?Model
    {
        $model_class = $this->getModelClass();

        /**
         * @var Builder $query
         */
        $query = $model_class::query();

        $query = $this->applyFilters($query, $filters);

        return $query->first();
    }

    /**
     * Get count models by simple filters
     *
     * @param array $filters
     * @return int
     */
    public function getCountByFilters(array $filters): int
    {
        $model_class = $this->getModelClass();

        /**
         * @var Builder $query
         */
        $query = $model_class::query();

        $query = $this->applyFilters($query, $filters);

        return $query->count();
    }
}
