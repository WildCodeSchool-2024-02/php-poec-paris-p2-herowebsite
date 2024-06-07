<?php

namespace App\Model;

use PDO;

class SceneManager extends AbstractManager
{
    public const TABLE = "`scene`";

    public function insert(array $scene): ?int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            "(`name`, `background`, `story_id`) VALUES (:name, :background, :story_id)");
        $statement->bindValue('name', $scene['name'], PDO::PARAM_STR);
        $statement->bindValue('background', $scene['background'], PDO::PARAM_STR);
        $statement->bindValue('story_id', $scene['story_id'], PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function findFirstSceneIdOfStory(int $storyId): int|false
    {
        $statement = $this->pdo->prepare(
            "SELECT story.*, MIN(sc.id) AS scene_id
    FROM story
    JOIN scene sc ON sc.story_id = story.id
    GROUP BY story.id;"
        );

        $statement->bindValue(':storyId', $storyId, PDO::PARAM_INT);
        $statement->execute();

        // Retourne l'id de la première scène si trouvée, sinon false
        $row = $statement->fetch();
        return intval($row['id']);
    }

    public function selectAllByStory(string $storyId): array
    {
        $query = 'SELECT * FROM ' . static::TABLE .
            'WHERE story_id = ' . $storyId . ';';

        $result = $this->pdo->query($query)->fetchAll();
        return $this->decodeHtmlEntitiesInArray($result);
    }
}
