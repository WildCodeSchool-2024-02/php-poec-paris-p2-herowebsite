<?php

namespace App\Model;

class SceneManager extends AbstractManager
{
    public const TABLE = 'scene';

    public function findScene(int $storyId, int $sceneId): array|false
    {
        // Prepare the SQL query to select the first scene of the specified story
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE story_id = :storyId AND id = :sceneId ORDER BY id ASC LIMIT 1"
        );

        // Bind parameter values
        $statement->bindValue(':storyId', $storyId, \PDO::PARAM_INT);
        $statement->bindValue(':sceneId', $sceneId, \PDO::PARAM_INT);
        // Execute the query
        $statement->execute();

        // Return the first scene if exists, otherwise return false
        return $statement->fetch();
    }

    public function findFirstSceneIdOfStory(int $storyId): int|false
    {
        // Préparer la requête SQL pour récupérer l'identifiant de la première scène de l'histoire
        $statement = $this->pdo->prepare(
            "SELECT id FROM scene WHERE story_id = :storyId ORDER BY id ASC LIMIT 1"
        );

        // Bind parameter values
        $statement->bindValue(':storyId', $storyId, \PDO::PARAM_INT);
        // Execute the query
        $statement->execute();

        // Return the first scene if exists, otherwise return false
        $row = $statement->fetch();
        return intval($row['id']);
    }
}
