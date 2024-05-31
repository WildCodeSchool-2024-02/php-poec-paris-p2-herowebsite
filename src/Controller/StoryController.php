<?php

namespace App\Controller;

use App\Model\StoryManager;

class StoryController extends AbstractController
{
    public function indexCreation(): ?string
    {
        $storyManager = new StoryManager();
        $stories = $storyManager->selectAll();

        return $this->twig->render('StoryCreation/index.html.twig', ['stories' => $stories]);
    }
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

    public function show(string $id): string
    {
        $storyManager = new StoryManager();
        $story = $storyManager->selectOneById((int) $id);
        $scenes = $storyManager->getScenes($id);

        return $this->twig->render(
            'StoryCreation/show.html.twig',
            [
                'story' => $story,
                'scenes' => $scenes
            ]
        );
    }

    public function delete(int $id): ?string
    {
        $storyManager = new StoryManager();
        $storyManager->delete((int) $id);

        header('Location:/storycreation');
        return null;
    }
}
