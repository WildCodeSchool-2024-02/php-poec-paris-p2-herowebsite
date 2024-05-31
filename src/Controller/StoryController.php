<?php

namespace App\Controller;

use App\Model\StoryManager;

class StoryController extends AbstractController
{
    public function add(): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $storyManager = new StoryManager();
            $story = array_map('trim', $_POST);
            $id = $storyManager->insert($story);

            header('Location:/storycreation/show?id=' . $id);
            return null;
        }

        return $this->twig->render('StoryCreation/add.html.twig');
    }

    public function show(int $id): string
    {
        $storyManager = new StoryManager();
        $story = $storyManager->selectOneById($id);

        return $this->twig->render('StoryCreation/show.html.twig', ['story' => $story]);
    }

    public function goToSceneCreation(int $story_id): string
    {
        return $this->twig->render('SceneCreation/add.html.twig', ['story_id' => $story_id]);
    }
}
