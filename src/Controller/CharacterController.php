<?php

namespace App\Controller;

use App\Model\CharacterManager;

class CharacterController extends AbstractController
{
    private $characterManager;

    private const TARGET_DIR = 'assets/images/sprites/';
    public const EXTENSIONS_ALLOWED = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    public const MAX_UPLOAD_SIZE = 5000000;

    public function __construct()
    {
        parent::__construct();
        $this->characterManager = new CharacterManager();
    }
    public function add($storyId, $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $character['story_id'] = $storyId;
            $targetFile = self::TARGET_DIR . basename($_FILES['sprite']['name']);
            $typeFile = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $dimensionsImage = getimagesize($_FILES['sprite']['tmp_name']);
            $errors = [];

            if (!$dimensionsImage) {
                $errors[] = 'Votre sprite n\'est pas une image';
            }

            if ($_FILES['sprite']['size'] > self::MAX_UPLOAD_SIZE) {
                $errors[] = 'Votre sprite ne peut pas dépasser 5Mo';
            }

            if (!in_array($typeFile, self::EXTENSIONS_ALLOWED)) {
                $errors[] = 'Votre sprite n\'as pas le bon format (' . implode(', ', self::EXTENSIONS_ALLOWED) . ')';
            }

            if (!move_uploaded_file($_FILES['sprite']['tmp_name'], $targetFile)) {
                $errors[] = 'Erreur lors du déplacement du fichier de sprite';

                error_log('Erreur lors du déplacement du fichier de sprite: ' . $_FILES['sprite']['error']);
            }

            if (empty($errors)) {
                $character['sprite'] = basename($_FILES['sprite']['name']);
                $this->characterManager->insert($character);
            } else {
                // Log des erreurs dans un fichier de journal
                error_log('Erreurs lors de l\'ajout du sprite: ' . implode(', ', $errors));
                // Ajout du personnage en cas d'absence de sprite
                $this->characterManager->insert($character);
            }
        }

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $this->characterManager->delete((int) $id);

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(string $storyId, string $sceneId, int $id): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $character['name'] = $character['e_name'];
            $character['sprite'] = $character['e_sprite'];
            $this->characterManager->update($id, $character);
        }
        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
