<?php

namespace Api\Repository;

use Exception;
use PDO;
use DateTime;
use DateTimeZone;

abstract class Repository implements CRUDInterface, CRUDExtensionsInterface
{
    /**
     * @var string
     */
    protected string $tableName;

    /**
     * @var PDO
     */
    protected PDO $db;

    /**
     * Repository constructor.
     *
     * @param PDO $db
     * @param string $tableName
     */
    public function __construct(PDO $db, string $tableName)
    {
        $this->db = $db;
        $this->tableName = $tableName;
    }

    /**
     * @return array|false
     * @throws Exception
     */
    public function getAll(): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->tableName");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $model
     * @param int $page
     * @param int $perPage
     * @return array|false
     * @throws Exception
     */
    public function search(array $model, int $page, int $perPage, string $orderColumn = 'id', string $orderDirection = 'ASC'): array|false
    {
        $where = '';
        if (count(array_keys($model)) > 0) {
            $where = "WHERE " . implode(" = ? AND ", array_keys($model)) . " = ? ";
        }

        $pagination = '';
        if ($page > 0 && $perPage > 0) {
            $pagination = sprintf("LIMIT %d OFFSET %d", $perPage, ($page - 1) * $perPage);
        }

        $orderQuery = '';
        if ($orderColumn && $orderDirection) {
            $orderQuery = "ORDER BY {$orderColumn} {$orderDirection}";
        }

        $query = "SELECT * FROM {$this->tableName} {$where} {$orderQuery} {$pagination}";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($model));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $model
     * @return mixed
     * @throws Exception
     */
    public function create(array $model): int
    {
        $attribute = $this->search($model, 1, 1);
        if (count($attribute) > 0) {
            throw new Exception("The attribute already exists!");
        }

        $intoColumns = implode(",", array_keys($model));
        $placeholders = implode(",", array_fill(0, count(array_keys($model)), "?"));
        $query = "INSERT INTO $this->tableName ($intoColumns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($model));

        return $this->db->lastInsertId() ? intval($this->db->lastInsertId()) : 0;
    }

    /**
     * @param array $model
     * @return int
     * @throws Exception
     */
    public function update(array $model): int
    {
        $attributeId = $model["id"];
        $row = $this->getById($attributeId);
        if (!$row) {
            return 0;
        }

        unset($model["id"]);

        $updateSets = [];
        foreach (array_keys($model) as $column) {
            $updateSets[] = sprintf("%s = ?", $column);
        }
        $updateSetsAsString = implode(", ", $updateSets);

        $currentDateTime = new DateTime("now", new DateTimeZone('Europe/Helsinki'));

        $query = "UPDATE $this->tableName SET $updateSetsAsString, updated_at = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$model['name'], $currentDateTime->format('Y-m-d H:i:s'), $attributeId]);

        return $stmt->rowCount();
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getById(int $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->tableName WHERE id = :id");
        $stmt->execute(array(":id" => $id));

        return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function delete(int $id): int
    {
        $query = "DELETE FROM $this->tableName WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function softDelete(int $id): int
    {
        $row = $this->getById($id);
        if (!$row) {
            return 0;
        }

        $query = "UPDATE $this->tableName SET is_deleted = false WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    /**
     * Retrieves count of founded rows.
     *
     * @param array $model
     * @return int
     */
    public function count(array $model): int
    {
        $where = '';
        if (count(array_keys($model)) > 0) {
            $where = "WHERE " . implode(" = ? AND ", array_keys($model)) . " = ? ";
        }

        $query = "SELECT id FROM $this->tableName $where";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($model));

        return $stmt->rowCount();

    }
}