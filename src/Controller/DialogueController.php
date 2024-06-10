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
    public function add(): ?string
    {
        $dialogue = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogue = array_map('htmlentities', array_map('trim', $_POST));
            $this->dialogueManager->insert($dialogue);
        }
        header('Location:/storycreation/scene/show?story_id='
            . $dialogue['story_id'] . '&id=' . $dialogue['scene_id']);
        return null;
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $this->dialogueManager->delete((int) $id);

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(): ?string
    {
        $dialogue = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogue = array_map('htmlentities', array_map('trim', $_POST));
            $this->dialogueManager->update($dialogue);
        }
        header('Location:/storycreation/scene/show?story_id=' . $dialogue['story_id'] . '&id=' . $dialogue['scene_id']);
        return null;
    }
}
