<?php

namespace Api\Repository;

use Exception;

interface CRUDInterface
{
    /**
     * Retrieve record by id.
     *
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function getById(int $id): mixed;

    /**
     * Retrieves all records.
     *
     * @return array|false
     */
    public function getAll(): array|false;

    /**
     * @param array $model
     * @param int $page
     * @param int $perPage
     * @return array|false
     * @throws Exception
     */
    public function search(array $model, int $page, int $perPage, string $orderColumn, string $orderDirection): array|false;

    /**
     * Create a new record.
     *
     * @param array $model
     * @return mixed
     * @throws Exception
     */
    public function create(array $model): int;

    /**
     * Update record.
     *
     * @param array $model
     * @return mixed
     * @throws Exception
     */
    public function update(array $model): int;

    /**
     * Delete record by id.
     *
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function delete(int $id): int;
}