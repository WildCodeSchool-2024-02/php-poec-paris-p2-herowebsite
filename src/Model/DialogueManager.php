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
        $statement->bindValue("body", $dialogues["body"], PDO::PARAM_STR);
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

    public function getDialogues(string $id): ?array
    {
        $statement = $this->pdo->query("SELECT d.*, c.name AS character_name FROM " . self::TABLE . "AS d 
        INNER JOIN `character` AS c
        ON d.character_id = c.id 
        WHERE `scene_id` = " . $id . ";");

        $dialogues = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($dialogues);
    }

    /**
     * Récupère les dialogues & les personnages associés par l'ID de la scène.
     */
    public function getDialoguesBySceneId(int $sceneId): ?array
    {
        $query = "SELECT dl.id, dl.body, dl.character_id, c.name AS character_name, c.sprite
                  FROM " . static::TABLE . " dl
                  JOIN `character` c ON dl.character_id = c.id
                  WHERE dl.scene_id = :scene_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('scene_id', $sceneId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
