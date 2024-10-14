<?php

namespace Api\Repository;

use PDO;

class ProductsRepository extends Repository
{
    /**
     * @var string
     */
    protected string $tableName = "products";

    /**
     * @var array
     */
    protected array $allowedColumns = ['id', 'name', 'code', 'price', 'created_at', 'updated_at', 'is_deleted'];

    /**
     * @var PDO
     */
    protected PDO $db;

    /**
     * PagesRepository constructor.
     *
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
        parent::__construct($db, $this->tableName);
    }

    /**
     * @param array $model
     * @param int $page
     * @param int $perPage
     * @return array|false
     * @throws \Exception
     */
    public function search(array $model, int $page, int $perPage, $orderColumn = 'id', string $orderDirection = 'ASC'): array|false
    {
        $criteria = array_intersect_key(array_filter($model), array_flip($this->allowedColumns));

        return parent::search($criteria, $page, $perPage);
    }

    /**
     * @param array $model
     * @return int
     */
    public function count(array $model): int
    {
        $criteria = array_intersect_key(array_filter($model), array_flip($this->allowedColumns));

        return parent::count($criteria);
    }

    /**
     * @return array
     */
    public function getColumns(): array 
    {
        return $this->allowedColumns;
    }
}