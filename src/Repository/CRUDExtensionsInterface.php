<?php

namespace Api\Repository;

use Exception;

interface CRUDExtensionsInterface
{
    /**
     * Soft delete record by id.
     *
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function softDelete(int $id): int;
}