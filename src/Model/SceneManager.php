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

    public function getStory(string $id): array
    {
        $statement = $this->pdo->query("SELECT * FROM `story` WHERE `id` = " . $id . ";");

        $story = $statement->fetch(PDO::FETCH_ASSOC);

        return $story;
    }

    public function getDialogues(string $id): array
    {
        $statement = $this->pdo->query("SELECT id, body FROM `dialogue_line` WHERE `scene_id` = " . $id . ";");

        $dialogues = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $dialogues;
    }

    public function getChoices(string $id): array
    {
        $statement = $this->pdo->query("SELECT id, body FROM `choice` WHERE `scene_id` = " . $id . ";");

        $choices = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $choices;
    }
}
