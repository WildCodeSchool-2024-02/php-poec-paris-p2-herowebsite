<?php

namespace App\Model;

use PDO;

class CharacterManager extends AbstractManager
{
    public const TABLE = "`character`";

    public function insert(array $characters): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`name`, `sprite`, `story_id`) VALUE (:name, :sprite, :story_id);"
        );
        $statement->bindValue("name", $characters["name"], PDO::PARAM_STR);
        $statement->bindValue("sprite", $characters["sprite"], PDO::PARAM_STR);
        $statement->bindValue("story_id", $characters["story_id"], PDO::PARAM_STR);


        return $statement->execute();
    }

    public function update(array $characters): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE . 
            "SET name = " . $characters["name"] . 
            "sprite = " . $characters["sprite"] . ";"
        );

        return $statement->execute();    
    }

    public function getCharacters(string $storyId): array
    {
        $statement = $this->pdo->query(
            "SELECT * FROM " . self::TABLE . " WHERE `story_id` = " . $storyId . ";"
        );
        $characters = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $characters;
    }
}
