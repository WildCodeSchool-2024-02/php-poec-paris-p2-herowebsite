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

            header('Location:/storycreation/scene/show?id=' . $id);
            return null;
        }

        return $this->twig->render('SceneCreation/add.html.twig');
    }

    public function show(int $id): string
    {
        $sceneManager = new SceneManager();
        $scene = $sceneManager->selectOneById($id);

        return $this->twig->render('SceneCreation/show.html.twig', ['scene' => $scene]);
    }
}
