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
            " SET name = :name, sprite = :sprite
            WHERE id = :character_id ;"
        );

        $statement->bindValue(":name", $character["character_name"], PDO::PARAM_STR);
        $statement->bindValue(":sprite", $character["sprite"], PDO::PARAM_STR);
        $statement->bindValue(":character_id", $character["character_id"], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function selectAll(string $storyId = null, string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT * FROM " . self::TABLE . " 
            WHERE `story_id` = " . $storyId;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        $query .= ";";

        $statement = $this->pdo->query($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
