<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function count(): int;

    /**
     * @param  array<string>  $columns
     * @return LengthAwarePaginator<int, mixed>
     */
    public function paginate(int $itemPerPage = 15, array $columns = ['*'], string $sortBy = 'id', string $order = 'asc'): LengthAwarePaginator;

    /**
     * @param  array<string, mixed>  $data
     * @return Model|null
     */
    public function create(array $data);

    /**
     * @return Model|null
     */
    public function find(string $id);

    /**
     * @return Model|null
     */
    public function findBy(string $column, string $value);

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(string $id, array $data): bool;

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateBy(string $column, string $value, array $data): bool;

    public function delete(string $id): bool;
}
