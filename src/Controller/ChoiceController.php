<?php

namespace App\Controller;

use App\Model\ChoiceManager;

class ChoiceController extends AbstractController
{
    private $choiceManager;

    public function __construct()
    {
        parent::__construct();
        $this->choiceManager = new ChoiceManager();
    }
    public function add()
    {
        $choice = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choice = array_map('htmlentities', array_map('trim', $_POST));
            $this->choiceManager->insert($choice);

            header('Location:/story/engine/scene/show?story_id=' . $choice['story_id'] . '&id=' . $choice['scene_id']);
            return null;
        }
    }

    public function delete(string $storyId, string $sceneId, int $id)
    {
        $this->choiceManager->delete((int) $id);

        header('Location:/story/engine/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(): ?string
    {
        $choice = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choice = array_map('htmlentities', array_map('trim', $_POST));
            $this->choiceManager->update($choice['id'], $choice);
        }

        header('Location:/story/engine/scene/show?story_id=' . $choice['story_id'] . '&id=' . $choice['scene_id']);
        return null;
    }
}
