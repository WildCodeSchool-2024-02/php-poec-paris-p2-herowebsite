<?php

namespace App\Model;

use PDO;

class ChoiceManager extends AbstractManager
{
    public const TABLE = 'choice';

    /**
     * Récupère les choix par l'ID de la scène.
     */
    public function selectAll(string $sceneId = null, string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT c.*, s.name AS next_scene_name
                  FROM " . static::TABLE . " AS c
                  INNER JOIN scene AS s
                  ON c.next_scene_id = s.id
                  WHERE scene_id = :scene_id";

        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        $query .= ';';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('scene_id', $sceneId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function update(int $id, array $choice)
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET body = :body, next_scene_id = :next_scene_id
             WHERE id = :id ;"
        );

        $statement->bindValue(":body", $choice["choice_body"], PDO::PARAM_STR);
        $statement->bindValue(":next_scene_id", $choice["next_scene"], PDO::PARAM_STR);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function insert(array $choice)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        "(`body`, `scene_id`, `next_scene_id`) VALUES (:body, :scene_id, :next_scene_id)");
        $statement->bindValue('body', $choice['choice_body'], PDO::PARAM_STR);
        $statement->bindValue('scene_id', $choice['scene_id'], PDO::PARAM_STR);
        $statement->bindValue('next_scene_id', $choice['next_scene'], PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }
}
