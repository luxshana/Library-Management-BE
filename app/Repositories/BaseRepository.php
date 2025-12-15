<?php

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return Builder<Model>
     */
    public function queryBuilder(): Builder
    {
        /** @var Builder<Model> */
        return $this->model->query();
    }

    /**
     * @return Builder<Model>
     */
    protected function query(): Builder
    {
        $builder = $this->queryBuilder();

        if ($this->hasProperty('relationable') && ! empty($this->getProperty('relationable'))) {
            $builder = $this->relations($builder);
        }

        if ($this->hasProperty('filterable') && ! empty($this->getProperty('filterable'))) {
            $builder = $this->filters($builder);
        }

        if ($this->hasProperty('searchable') && ! empty($this->getProperty('searchable'))) {
            $builder = $this->search($builder);
        }

        return $builder;
    }

    /**
     * Check if model has a property
     */
    private function hasProperty(string $property): bool
    {
        return property_exists($this->model, $property);
    }

    /**
     * Get property from model with type safety
     *
     * @return mixed
     */
    private function getProperty(string $property)
    {
        if (! $this->hasProperty($property)) {
            return null;
        }

        return $this->model->{$property};
    }

    /**
     * @param  Builder<Model>  $builder
     * @return Builder<Model>
     */
    protected function relations(Builder $builder): Builder
    {
        $relationable = $this->getProperty('relationable');

        if (! is_array($relationable) || empty($relationable)) {
            return $builder;
        }

        foreach ($relationable as $key => $columns) {
            if (! is_string($key) || ! is_array($columns)) {
                continue;
            }

            $builder->with([$key => function ($q) use ($columns) {
                if (! $q instanceof Relation) {
                    return;
                }
                $q->select($columns);
            }]);
        }

        return $builder;
    }

    /**
     * @param  Builder<Model>  $builder
     * @return Builder<Model>
     */
    protected function filters(Builder $builder): Builder
    {
        $filterable = $this->getProperty('filterable');

        if (! is_array($filterable) || empty($filterable)) {
            return $builder;
        }

        $requestData = request()->all();

        foreach ($requestData as $key => $value) {
            if (! is_string($key) || is_null($value) || ! array_key_exists($key, $filterable)) {
                continue;
            }

            $operator = $filterable[$key];

            if ($operator === 'in' && is_array($value)) {
                $builder->whereIn($key, $value);
            } else {
                $searchValue = $operator === 'like' ? (is_scalar($value) ? (string) $value.'%' : $value) : $value;
                $builder->where($key, $operator, $searchValue);
            }
        }

        return $builder;
    }

    /**
     * Apply search filters to the query builder
     *
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    protected function search(Builder $query): Builder
    {
        $searchQuery = request()->input('query', '');

        if (! is_string($searchQuery) || $searchQuery === '') {
            return $query;
        }

        $searchable = $this->getProperty('searchable');

        if (! is_array($searchable) || empty($searchable)) {
            return $query;
        }

        $query->where(function ($q) use ($searchQuery, $searchable) {
            /** @var Builder<Model> $q */
            $first = true;

            foreach ($searchable as $field) {
                if (! is_string($field)) {
                    continue;
                }

                if ($first) {
                    $q->where($field, 'like', "%{$searchQuery}%");
                    $first = false;
                } else {
                    $q->orWhere($field, 'like', "%{$searchQuery}%");
                }
            }

            $relationableSearchable = $this->getProperty('relationableSearchable');

            if (is_array($relationableSearchable) && ! empty($relationableSearchable)) {
                foreach ($relationableSearchable as $key => $field) {
                    if (! is_string($key) || ! is_string($field)) {
                        continue;
                    }

                    if ($first) {
                        $q->whereHas($key, function ($qh) use ($field, $searchQuery) {
                            /** @var Builder<Model> $qh */
                            $qh->where($field, 'like', "%{$searchQuery}%");
                        });
                        $first = false;
                    } else {
                        $q->orWhereHas($key, function ($qh) use ($field, $searchQuery) {
                            /** @var Builder<Model> $qh */
                            $qh->where($field, 'like', "%{$searchQuery}%");
                        });
                    }
                }
            }
        });

        return $query;
    }

    public function find(string $id): ?Model
    {
        /** @var Model|null */
        return $this->model->find($id);
    }

    public function findBy(string $column, string $value): ?Model
    {
        /** @var Model|null */
        return $this->model->where($column, $value)->first();
    }

    /**
     * @param  array<string>  $columns
     * @return Collection<int, Model>
     */
    public function all(array $columns = ['*']): Collection
    {
        /** @var Collection<int, Model> */
        return $this->query()->select($columns)->get();
    }

    public function count(): int
    {
        return $this->query()->count();
    }

    /**
     * @param  array<string>  $columns
     * @return LengthAwarePaginator<int, Model>
     */
    public function paginate(int $itemPerPage = 15, array $columns = ['*'], string $sortBy = 'id', string $order = 'asc'): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<int, Model> */
        return $this->query()->select($columns)->orderBy($sortBy, $order)->paginate($itemPerPage);
    }

    /**
     * @param  array<string>  $columns
     * @return Collection<int, Model>
     */
    public function take(int $limit = 15, array $columns = ['*'], string $column = 'created_at', string $direction = 'desc'): Collection
    {
        /** @var Collection<int, Model> */
        return $this->query()->select($columns)->orderBy($column, $direction)->limit($limit)->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): ?Model
    {
        /** @var Model|null */
        return $this->model->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(string $id, array $data): bool
    {
        $model = $this->find($id);

        if ($model === null) {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateBy(string $column, string $value, array $data): bool
    {
        $result = $this->model->where($column, $value)->update($data);

        return $result > 0;
    }

    public function delete(string $id): bool
    {
        $model = $this->find($id);

        if ($model === null) {
            return false;
        }

        return (bool) $model->delete();
    }
}
