<?php

namespace App\Controller;

class StoryController extends AbstractController
{
    /**
     * Affiche la page de sélection d'histoire
     */
    public function index(): string
    {
        $stories = $this->storyManager->selectAll();

        return $this->twig->render('Story/index.html.twig', ['stories' => $stories]);
    }
}
