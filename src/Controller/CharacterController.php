<?php

namespace App\Controller;

use App\Model\CharacterManager;

class CharacterController extends AbstractController
{
    public function add($storyId, $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $characterManager = new CharacterManager();
            $character = array_map('trim', $_POST);
            $character['story_id'] = $storyId;
            $characterManager->insert($character);
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

    public function update(string $storyId, string $sceneId, int $id): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $characterManager = new CharacterManager();
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $character['name'] = $character['e_name'];
            $character['sprite'] = $character['e_sprite'];
            $characterManager->update($id, $character);
        }

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
