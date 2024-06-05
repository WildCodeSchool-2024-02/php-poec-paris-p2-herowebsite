<?php

namespace App\Model;

class ChoiceManager extends AbstractManager
{
    public const TABLE = 'choice';

    /**
     * Récupère les choix par l'ID de la scène.
     */
    public function getChoicesBySceneId(int $sceneId): ?array
    {
        $query = "SELECT id, body, next_scene_id
                  FROM " . static::TABLE . "
                  WHERE scene_id = :scene_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('scene_id', $sceneId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
