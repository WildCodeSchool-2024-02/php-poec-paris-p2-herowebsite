<?php

namespace App\Controller;

use App\Model\SceneManager;

class SceneController extends AbstractController
{
    public function add(int $storyId): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sceneManager = new SceneManager();
            $scene = array_map('trim', $_POST);
            $scene['story_id'] = $storyId;
            $id = $sceneManager->insert($scene);

            header('Location:/storycreation/scene/show?' . http_build_query(['story_id' => $storyId, 'id' => $id]));
            return null;
        }

        return $this->twig->render('SceneCreation/add.html.twig');
    }

    public function showCreation(string $storyId, string $id): string
    {
        $sceneManager = new SceneManager();
        $scene = $sceneManager->selectOneById((int) $id);
        $story = $sceneManager->getStory($storyId);

        return $this->twig->render(
            'SceneCreation/show.html.twig',
            [
                'scene' => $scene,
                'story' => $story
            ]
        );
    }

    public function delete(string $storyId, string $sceneId): ?string
    {
        $sceneManager = new SceneManager();
        $sceneManager->delete((int) $sceneId);

        header('Location:/storycreation/show?id=' . $storyId);
        return null;
    }
}
