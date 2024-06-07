<?php

namespace App\Model;

use PDO;

class DialogueManager extends AbstractManager
{
    public const TABLE =  "`dialogue_line`";

    public function insert(array $dialogues): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`body`, `character_id`, `scene_id`)
            VALUE (:body, :character_id, :scene_id);"
        );
        $statement->bindValue("body", $dialogues["dial_body"], PDO::PARAM_STR);
        $statement->bindValue("character_id", $dialogues["character_id"], PDO::PARAM_STR);
        $statement->bindValue("scene_id", $dialogues["scene_id"], PDO::PARAM_STR);


        return $statement->execute();
    }

    public function update(int $id, array $dialogues): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET body = \"" . $dialogues["body"] .
            "\", character_id = " . $dialogues["character_id"] .
            " WHERE id = " . $id . ";"
        );

        return $statement->execute();
    }

    public function selectAllByScene(string $sceneId): ?array
    {
        $statement = $this->pdo->query(
            "SELECT d.*, c.* FROM " . self::TABLE . " AS d
    INNER JOIN `character` AS c
    ON d.character_id = c.id
    WHERE `scene_id` = " . $sceneId . ";"
        );

        $dialogues = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($dialogues);
    }
}
