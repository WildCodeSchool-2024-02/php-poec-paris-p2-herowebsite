<?php

namespace App\Controller;

use App\Model\StoryCreationManager;

class StoryCreationController extends AbstractController
{
    public function add(): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $storyCreationManager = new StoryCreationManager();
            $story = array_map('trim', $_POST);
            $id = $storyCreationManager->insert($story);

            header('Location:/StoryCreation/show?id=' . $id);
            return null;
        }

        return $this->twig->render('StoryCreation/add.html.twig');
    }

    public function show(int $id): string
    {
        $storyCreationManager = new StoryCreationManager();
        $story = $storyCreationManager->selectOneById($id);

        return $this->twig->render('StoryCreation/show.html.twig', ['story' => $story]);
    }

    public function goToSceneCreation(int $story_id): string
    {
        return $this->twig->render('StoryCreation/SceneCreation/add.html.twig', ['story_id' => $story_id]);
    }
}
