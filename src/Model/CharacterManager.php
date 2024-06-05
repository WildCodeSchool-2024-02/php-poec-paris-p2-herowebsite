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
        $statement->bindValue("name", $character["name"], PDO::PARAM_STR);
        $statement->bindValue("sprite", $character["sprite"], PDO::PARAM_STR);
        $statement->bindValue("story_id", $character["story_id"], PDO::PARAM_STR);


        return $statement->execute();
    }

    public function update(int $id, array $character): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET name = \"" . $character["name"] .
            "\", sprite = \"" . $character["sprite"] . "\"
            WHERE id = " . $id . ";"
        );
        return $statement->execute();
    }

    public function getCharacters(string $storyId): ?array
    {
        $statement = $this->pdo->query(
            "SELECT * FROM " . self::TABLE . " WHERE `story_id` = " . $storyId . ";"
        );
        $characters = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->decodeHtmlEntitiesInArray($characters);
    }
}
