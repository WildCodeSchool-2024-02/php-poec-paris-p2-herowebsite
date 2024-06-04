<?php

namespace App\Controller;

use App\Model\CharacterManager;

class CharacterController extends AbstractController
{
    public function add($storyId, $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $characterManager = new CharacterManager();
            $characters = array_map('trim', $_POST);
            $characters['story_id'] = $storyId;
            $characterManager->insert($characters);
        }

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $characterManager = new CharacterManager();
        $characterManager->delete((int) $id);

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
