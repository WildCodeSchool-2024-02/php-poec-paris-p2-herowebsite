<?php

namespace App\Controller;

class StoryController extends AbstractController
{
    public function indexCreation(): ?string
    {
        $stories = $this->storyManager->selectAll();

        return $this->twig->render('StoryCreation/index.html.twig', ['stories' => $stories]);
    }
    public function add(): ?string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $story = array_map('htmlentities', array_map('trim', $_POST));
            $id = $this->storyManager->insert($story);

            header('Location:/storycreation/show?id=' . $id);
            return null;
        }

        return $this->twig->render('StoryCreation/add.html.twig');
    }

    public function showCreation(string $id): string
    {
        $story = $this->storyManager->selectOneById((int) $id);
        $scenes = $this->storyManager->getScenes($id);

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
        $this->storyManager->delete((int) $id);

        header('Location:/storycreation');
        return null;
    }
    /**
     * Affiche la page de sélection d'histoire
     */
    public function index(): string
    {
        $stories = $this->storyManager->selectAll();

        return $this->twig->render('Story/index.html.twig', ['stories' => $stories]);
    }
}
