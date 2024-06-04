<?php

namespace App\Model;

class DialogueManager extends AbstractManager
{
    public const TABLE = 'dialogue_line';

    /**
     * Récupère les dialogues & les personnages associés par l'ID de la scène.
     */
    public function getDialoguesBySceneId(int $sceneId): array
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
