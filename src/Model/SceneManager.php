<?php

namespace App\Model;

class SceneManager extends AbstractManager
{
    public const TABLE = 'scene';

    /**
     * Récupère scène par son ID et celui de l'histoire.
     */
    public function findScene(int $storyId, int $sceneId): array|false
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE story_id = :storyId AND id = :sceneId"
        );

        $statement->bindValue(':storyId', $storyId, \PDO::PARAM_INT);
        $statement->bindValue(':sceneId', $sceneId, \PDO::PARAM_INT);
        $statement->execute();

        // Retourne la scène si trouvée, sinon false
        return $statement->fetch();
    }

    /**
     * Récupère l'ID de la première scène associée à une histoire.
     */
    public function findFirstSceneIdOfStory(int $storyId): int|false
    {
        $statement = $this->pdo->prepare(
            "SELECT id FROM scene WHERE story_id = :storyId ORDER BY id ASC LIMIT 1"
        );

        $statement->bindValue(':storyId', $storyId, \PDO::PARAM_INT);
        $statement->execute();

        // Retourne l'id de la première scène si trouvée, sinon false
        $row = $statement->fetch();
        return intval($row['id']);
    }
}
