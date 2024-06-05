<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected PDO $pdo;

    public const TABLE = '';

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        $result = $this->pdo->query($query)->fetchAll();
        return $this->decodeHtmlEntitiesInArray($result);
    }

    /**
     * Get one row from database by ID.
     */
    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch();
        return $this->decodeHtmlEntitiesInArray($result);
    }

    /**
     * Delete row form an ID
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function decodeHtmlEntitiesInArray(array|null $array): ?array
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $this->decodeHtmlEntitiesInArray($value);
                } elseif ($value !== null) {
                    $array[$key] = html_entity_decode($value);
                }
            }
        }
        return $array;
    }
}
