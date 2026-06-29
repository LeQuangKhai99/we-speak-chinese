<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * Get all records.
     *
     * @param  array  $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Find a record by ID.
     *
     * @param  int|string  $id
     * @param  array  $columns
     * @return Model|null
     */
    public function find(int|string $id, array $columns = ['*']): ?Model;

    /**
     * Create a new record.
     *
     * @param  array  $details
     * @return Model
     */
    public function create(array $details): Model;

    /**
     * Update an existing record.
     *
     * @param  int|string  $id
     * @param  array  $details
     * @return bool|Model
     */
    public function update(int|string $id, array $details): bool|Model;

    /**
     * Delete a record by ID.
     *
     * @param  int|string  $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Paginate records.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
}
