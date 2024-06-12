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
        $statement->bindValue('story_id', $scene['story_id'], PDO::PARAM_INT);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function update(array $scene): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `name` = :name, `background` = :background
            WHERE `id` = :scene_id ;"
        );
        $statement->bindValue(':name', $scene['name'], PDO::PARAM_STR);
        $statement->bindValue(':background', $scene['background'], PDO::PARAM_STR);
        $statement->bindValue(':scene_id', $scene['scene_id'], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function selectFirstByStory(int $storyId): ?array
    {
        $statement = $this->pdo->prepare(
            "SELECT sc.id AS scene_id
            FROM scene sc
            WHERE sc.story_id = :storyId
            ORDER BY sc.id ASC
            LIMIT 1;"
        );

        $statement->bindValue(':storyId', $storyId, PDO::PARAM_INT);
        $statement->execute();

        // Retourne l'id de la première scène si trouvée, sinon false
        return $statement->fetch();
    }

    public function selectAll(string $storyId = null, string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE .
            'WHERE story_id = ' . $storyId;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        $query  .= ';';

        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllByStory(string $storyId): array
    {
        $query = "SELECT * FROM " . static::TABLE .
            " WHERE story_id = " . $storyId . ";";

        return $this->pdo->query($query)->fetchAll();
    }
}
