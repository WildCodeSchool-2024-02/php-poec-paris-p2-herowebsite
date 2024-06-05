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

    public function getStory(string $id): ?array
    {
        $statement = $this->pdo->query("SELECT * FROM `story` WHERE `id` = " . $id . ";");

        $story = $statement->fetch(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($story);
    }

    public function getChoices(string $id): ?array
    {
        $statement = $this->pdo->query("SELECT id, body FROM `choice` WHERE `scene_id` = " . $id . ";");

        $choices = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($choices);
    }

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
