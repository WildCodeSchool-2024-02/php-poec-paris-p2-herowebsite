<?php

namespace App\Model;

use PDO;

class StoryManager extends AbstractManager
{
    public const TABLE = 'story';

    /**
     * Insert new story in database
     */
    public function insert(array $story): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`) VALUES (:name)");
        $statement->bindValue('name', $story['name'], PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function update(array $story, string $name): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name WHERE id=:id");
        $statement->bindValue('id', $story['id'], PDO::PARAM_INT);
        $statement->bindValue('name', $name, PDO::PARAM_STR);

        return $statement->execute();
    }

    public function getScenes(string $storyId): array
    {
        $statement = $this->pdo->query(
            "SELECT scene.* FROM `scene`
            INNER JOIN `story` ON story.id = scene.story_id
            WHERE story.id = " . $storyId .
            " ORDER BY scene.id;"
        );

        $scenes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $scenes;
    }
}
