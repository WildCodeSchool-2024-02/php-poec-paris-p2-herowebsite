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
            " SET body = :body, 
            character_id = :character_id 
            WHERE id = :dialogue_id;"
        );

        $statement->bindValue(":body", $dialogue["dialogue_body"], PDO::PARAM_STR);
        $statement->bindValue(":character_id", $dialogue["character_id"], PDO::PARAM_STR);
        $statement->bindValue(":dialogue_id", $dialogue["dialogue_id"], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function selectAll(string $sceneId = null, string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT d.*, c.id AS character_id, c.name, c.sprite, c.story_id FROM " . self::TABLE . " AS d
            INNER JOIN `character` AS c
            ON d.character_id = c.id
            WHERE `scene_id` = " . $sceneId;

        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

            $query .= ";";

        $statement = $this->pdo->query($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
