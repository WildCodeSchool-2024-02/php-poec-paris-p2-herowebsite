<?php

namespace App\Controller;

class ChoiceController extends AbstractController
{
    public function add(string $storyId, string $sceneId, string $nextSceneId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choice = array_map('htmlentities', array_map('trim', $_POST));
            $choice['scene_id'] = $sceneId;
            $choice['next_scene_id'] = $nextSceneId;
            $this->choiceManager->insert($choice);

            header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
            return null;
        }
    }

    public function delete(string $storyId, string $sceneId, int $id)
    {
        $this->choiceManager->delete((int) $id);

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(string $storyId, string $sceneId, int $id): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choice = array_map('htmlentities', array_map('trim', $_POST));
            $choice['body'] = $choice['e_body'];
            $choice['next_scene_id'] = $choice['e_next_scene'];
            $this->choiceManager->update($id, $choice);
        }

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
