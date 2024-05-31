<?php

namespace App\Model;

use PDO;

class SceneManager extends AbstractManager
{
    public const TABLE = 'scene';

    public function insert(array $scene): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        "(`name`, `background`, `story_id`) VALUES (:name, :background, :story_id)");
        $statement->bindValue('name', $scene['name'], PDO::PARAM_STR);
        $statement->bindValue('background', $scene['background'], PDO::PARAM_STR);
        $statement->bindValue('story_id', $scene['story_id'], PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function getStory(int $id): array
    {
        $statement = $this->pdo->query("SELECT * FROM `story` WHERE `id` = " . $id . ";");

        $story = $statement->fetch(PDO::FETCH_ASSOC);

        return $story;
    }
}
