<?php

namespace App\Controller;

use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\CharacterManager;

class DialogueController extends AbstractController
{
    public function add(string $storyId, string $sceneId): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogueManager = new DialogueManager();
            $dialogues = array_map('trim', $_POST);
            $dialogues['scene_id'] = $sceneId;
            $dialogueManager->insert($dialogues);

            header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
            return null;
        }

        $sceneManager = new SceneManager();
        $characterManager = new CharacterManager();

        $story = $sceneManager->getStory($storyId);
        $scene = $sceneManager->selectOneById((int) $sceneId);
        $characters = $characterManager->getCharacters($storyId);

        return $this->twig->render(
            'DialogueCreation/add.html.twig',
            [
                'story' => $story,
                'scene' => $scene,
                'characters' => $characters,
            ]
        );
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $dialogueManager = new DialogueManager();
        $dialogueManager->delete((int) $id);

        header('Location:/storycreation/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }
}
