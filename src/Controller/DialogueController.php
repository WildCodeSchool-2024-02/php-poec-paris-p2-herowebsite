<?php

namespace App\Controller;

use App\Model\DialogueManager;

class DialogueController extends AbstractController
{
    private $dialogueManager;

    public function __construct()
    {
        parent::__construct();
        $this->dialogueManager = new DialogueManager();
    }
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

    public function update(string $storyId, string $sceneId, int $id): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogue = array_map('htmlentities', array_map('trim', $_POST));
            $dialogue['body'] = $dialogue['e_dial_body'];
            $dialogue['character_id'] = $dialogue['e_character_id'];
            $this->dialogueManager->update($id, $dialogue);
        }
        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
