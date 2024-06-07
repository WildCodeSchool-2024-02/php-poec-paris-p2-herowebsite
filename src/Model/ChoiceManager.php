<?php

namespace App\Model;

use PDO;

class ChoiceManager extends AbstractManager
{
    public const TABLE = 'choice';

    /**
     * Récupère les choix par l'ID de la scène.
     */
    public function selectAllByScene(int $sceneId): ?array
    {
        $query = "SELECT c.*, s.name AS next_scene_name
                  FROM " . static::TABLE . " AS c
                  INNER JOIN scene AS s
                  ON c.next_scene_id = s.id
                  WHERE scene_id = :scene_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('scene_id', $sceneId, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetchAll();
        return $this->decodeHtmlEntitiesInArray($result);
    }

    public function update(int $id, array $choice)
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET body = '" . $choice["body"] .
            "', next_scene_id = " . $choice["next_scene_id"] .
            " WHERE id = " . $id . ";"
        );
        return $statement->execute();
    }

    public function insert(array $choice)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        "(`body`, `scene_id`, `next_scene_id`) VALUES (:body, :scene_id, :next_scene_id)");
        $statement->bindValue('body', $choice['body'], PDO::PARAM_STR);
        $statement->bindValue('scene_id', $choice['scene_id'], PDO::PARAM_STR);
        $statement->bindValue('next_scene_id', $choice['next_scene'], PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }
}
