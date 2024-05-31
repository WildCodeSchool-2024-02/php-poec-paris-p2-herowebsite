<?php

namespace App\Model;

class SceneManager extends AbstractManager
{
    public const TABLE = 'scene';

    public function findScene(int $story_id, int $scene_id): array|false
    {
        // Préparez la requête SQL pour sélectionner la première scène de l'histoire spécifiée
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE story_id = :story_id AND id = :scene_id ORDER BY id ASC LIMIT 1"
        );

        // Liaison des valeurs des paramètres
        $statement->bindValue(':story_id', $story_id, \PDO::PARAM_INT);
        $statement->bindValue(':scene_id', $scene_id, \PDO::PARAM_INT);

        // Exécution de la requête
        $statement->execute();

        // Renvoie la première scène si elle existe, sinon renvoie false
        return $statement->fetch();
    }
}
    // protected PDO $pdo;

    //   (select sc.*, dl.body as dialogue_line, ch.name as character_name, ch.sprite as character_sprite, choice.body as choice
    //from scene as sc, dialogue_line as dl, `character` as ch, choice
    //where sc.id = dl.scene_id AND dl.character_id = ch.id AND choice.scene_id = sc.id;
    // public const TABLE = ['scene', 'dialogue_line', 'character'];

    //  function getSceneItems($id_scene)
    // {
    // 'SELECT * FROM ' . static::TABLE[0] 'as sc' . static::TABLE[1] .' as dl' . static::TABLE[2] . ' as ch ' . 'WHERE id_scene=id_scene';
    //}
