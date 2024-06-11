<?php

namespace App\Model;

use PDO;

class DialogueManager extends AbstractManager
{
    public const TABLE = "`dialogue_line`";

    public function insert(array $dialogues): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`body`, `character_id`, `scene_id`)
            VALUE (:body, :character_id, :scene_id);"
        );
        $statement->bindValue("body", $dialogues["dialogue_body"], PDO::PARAM_STR);
        $statement->bindValue("character_id", $dialogues["character_id"], PDO::PARAM_STR);
        $statement->bindValue("scene_id", $dialogues["scene_id"], PDO::PARAM_STR);


        return $statement->execute();
    }

    public function update(array $dialogue): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET body = \"" . $dialogue["dialogue_body"] .
            "\", character_id = " . $dialogue["character_id"] .
            " WHERE id = " . $dialogue["dialogue_id"] . ";"
        );

        return $statement->execute();
    }

    public function selectAllByScene(string $sceneId): ?array
    {
        $statement = $this->pdo->query(
            "SELECT d.*, c.id AS character_id, c.name, c.sprite, c.story_id FROM " . self::TABLE . " AS d
            INNER JOIN `character` AS c
            ON d.character_id = c.id
            WHERE `scene_id` = " . $sceneId . ";"
        );

        $dialogues = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($dialogues);
    }
}
