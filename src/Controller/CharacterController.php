<?php

namespace App\Controller;

class CharacterController extends AbstractController
{
    public function add($storyId, $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $character['story_id'] = $storyId;
            $this->characterManager->insert($character);
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
