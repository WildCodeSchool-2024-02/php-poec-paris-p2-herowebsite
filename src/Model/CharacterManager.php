<?php

namespace App\Model;

use PDO;

class CharacterManager extends AbstractManager
{
    public const TABLE = "`character`";

    public function insert(array $character): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`name`, `sprite`, `story_id`) VALUE (:name, :sprite, :story_id);"
        );
        $statement->bindValue("name", $character["character_name"], PDO::PARAM_STR);
        $statement->bindValue("sprite", $character["sprite"], PDO::PARAM_STR);
        $statement->bindValue("story_id", $character["story_id"], PDO::PARAM_STR);


        return $statement->execute();
    }

    public function update(array $character): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
                " SET name = \"" . $character["edit_character_name"] .
                "\", sprite = \"" . $character["edit_sprite"] . "\"
            WHERE id = " . $character['character_id'] . ";"
        );
        return $statement->execute();
    }

    public function selectByStory(string $storyId): ?array
    {
        $statement = $this->pdo->query(
            "SELECT * FROM " . self::TABLE . " WHERE `story_id` = " . $storyId . ";"
        );
        $characters = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($characters);
    }
}
