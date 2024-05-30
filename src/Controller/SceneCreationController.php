<?php

namespace App\Controller;

use App\Model\SceneCreationManager;

class SceneCreationController extends AbstractController
{
    public function add(int $storyId): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sceneCreationManager = new SceneCreationManager();
            $scene = array_map('trim', $_POST);
            $scene['story_id'] = $storyId;
            $id = $sceneCreationManager->insert($scene);

            header('Location:/StoryCreation/SceneCreation/show?id=' . $id);
            return null;
        }

        return $this->twig->render('SceneCreation/add.html.twig');
    }

    public function show(int $id): string
    {
        $sceneCreationManager = new SceneCreationManager();
        $scene = $sceneCreationManager->selectOneById($id);

        return $this->twig->render('SceneCreation/show.html.twig', ['scene' => $scene]);
    }
}
