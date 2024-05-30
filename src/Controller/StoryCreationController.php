<?php

namespace App\Controller;

use App\Model\StoryCreationManager;

class StoryCreationController extends AbstractController
{
    private $storyCreationManager = new StoryCreationManager();
    public function add(): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $story = array_map('trim', $_POST);
            $id = $this->storyCreationManager->insert($story);

            header('Location:/StoryCreation/show?id=' . $id);
            return null;
        }

        return $this->twig->render('StoryCreation/add.html.twig');
    }

    public function show(int $id): string
    {

        $story = $this->storyCreationManager->selectOneById($id);

        return $this->twig->render('StoryCreation/show.html.twig', ['story' => $story]);
    }
}
