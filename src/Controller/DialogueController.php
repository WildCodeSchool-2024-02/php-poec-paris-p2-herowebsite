<?php

namespace App\Controller;

class DialogueController extends AbstractController
{
    public function add(string $storyId, string $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogues = array_map('htmlentities', array_map('trim', $_POST));
            $dialogues['scene_id'] = $sceneId;
            $this->dialogueManager->insert($dialogues);
        }
            header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
            return null;
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $this->dialogueManager->delete((int) $id);

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
