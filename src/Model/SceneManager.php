<?php

namespace App\Model;

class SceneManager extends AbstractManager
{
    public const TABLE = 'scene';

    public function findScene(int $storyId, int $sceneId): array|false
    {
        // Prepare the SQL query to select the first scene of the specified story
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE story_id = :story_id AND id = :scene_id ORDER BY id ASC LIMIT 1"
        );

        // Bind parameter values
        $statement->bindValue(':story_id', $storyId, \PDO::PARAM_INT);
        $statement->bindValue(':scene_id', $sceneId, \PDO::PARAM_INT);

        // Execute the query
        $statement->execute();

        // Return the first scene if exists, otherwise return false
        return $statement->fetch();
    }
}
