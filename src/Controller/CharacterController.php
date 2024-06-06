<?php

namespace App\Controller;

class CharacterController extends AbstractController
{
    public function add($storyId, $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $character['story_id'] = $storyId;
            $targetDir = 'assets/images/sprites/';
            $targetFile = $targetDir . basename($_FILES['sprite']['name']);
            $typeFile = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $dimensionsImage = getimagesize($_FILES['sprite']['tmp_name']);

            if (!$dimensionsImage) {
                $errors[] = 'Votre sprite n\'est pas une image';
            }

            if ($_FILES['sprite']['size'] > parent::MAX_UPLOAD_SIZE) {
                $errors[] = 'Votre sprite ne peut pas dépasser 5Mo';
            }

            if (!in_array($typeFile, parent::EXTENSIONS_ALLOWED)) {
                $errors[] = 'Votre sprite n\'as pas le bon format (' . implode(', ', parent::EXTENSIONS_ALLOWED) . ')';
            }

            if (!move_uploaded_file($_FILES['sprite']['tmp_name'], $targetFile)) {
                $errors[] = 'Erreur lors du déplacement du fichier de sprite';
                // Log des informations d'erreur
                error_log('Erreur lors du déplacement du fichier de sprite: ' . $_FILES['sprite']['error']);
            }

            if (empty($errors)) {
                $character['sprite'] = basename($_FILES['sprite']['name']);
                $id = $this->characterManager->insert($character);
            } else {
                // Log des erreurs dans un fichier de journal
                error_log('Erreurs lors de l\'ajout dtu sprite: ' . implode(', ', $errors));
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
