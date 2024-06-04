<?php

namespace App\Controller;

class SceneController extends AbstractController
{
    public function add(int $storyId): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scene = array_map('htmlentities', array_map('trim', $_POST));
            $scene['story_id'] = $storyId;
            $id = $this->sceneManager->insert($scene);

            header('Location:/storycreation/scene/show?' . http_build_query(['story_id' => $storyId, 'id' => $id]));
            return null;
        }

        return $this->twig->render('SceneCreation/add.html.twig');
    }

    public function showCreation(string $storyId, string $id): string
    {
        $scene = $this->sceneManager->selectOneById((int) $id);
        $story = $this->sceneManager->getStory($storyId);
        $dialogues = $this->dialogueManager->getDialogues($id);
        $choices = $this->sceneManager->getChoices($id);
        $characters = $this->characterManager->getCharacters($storyId);

        return $this->twig->render(
            'SceneCreation/show.html.twig',
            [
                'scene' => $scene,
                'story' => $story,
                'dialogues' => $dialogues,
                'choices' => $choices,
                'characters' => $characters
            ]
        );
    }

    public function delete(string $storyId, string $sceneId): ?string
    {
        $this->sceneManager->delete((int) $sceneId);

        header('Location:/storycreation/show?id=' . $storyId);
        return null;
    }
}
